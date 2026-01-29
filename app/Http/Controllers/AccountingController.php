<?php

namespace App\Http\Controllers;
use App\Models\SalesOrder;
use App\Models\Accounting;
use App\Models\PurchaseOrder;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index()
    {
        // Totals derived from existing accounting transactions
        $totalRevenue = Accounting::where('transaction_type', 'Income')->sum('amount');
        $totalExpenses = Accounting::where('transaction_type', 'Expense')->sum('amount');
        $netProfit = $totalRevenue - $totalExpenses;
        $lastMonthRevenuePercentage = $this->lastMonthRevenue($totalRevenue);
        $lastMonthNetProfitPercentage = $this->lastMonthNetprofit($netProfit);
        $lastMonthExpensesPercentage = $this->lastMonthTotalExpenses($totalExpenses);
        
        // Fetch sales orders with accounting transactions for partial payment tracking
        $salesOrders = SalesOrder::with(['customer', 'accountingTransactions' => function($query) {
            $query->where('transaction_type', 'Income');
        }])
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function($so) {
                $totalPaid = $so->accountingTransactions->sum('amount');
                $so->remaining_balance = $so->total_amount - $totalPaid;
                $so->paid_amount_total = $totalPaid;
                return $so;
            })
            ->filter(function($so) {
                return $so->remaining_balance > 0;
            })
            ->values();
        
        // Show only purchase orders with remaining balance (not fully paid)
        $purchaseOrders = PurchaseOrder::with(['supplier', 'accountingTransactions' => function($query) {
            $query->where('transaction_type', 'Expense');
        }])
            ->whereHas('items', function($query) {
                $query->whereExists(function($subQuery) {
                    $subQuery->selectRaw(1)
                        ->from('inventory_movements')
                        ->whereColumn('inventory_movements.item_id', 'purchase_order_items.material_id')
                        ->where('inventory_movements.item_type', 'material')
                        ->where('inventory_movements.movement_type', 'in')
                        ->whereColumn('inventory_movements.reference_id', 'purchase_order_items.purchase_order_id')
                        ->where('inventory_movements.reference_type', 'purchase_order');
                });
            })
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function($po) {
                $totalPaid = $po->accountingTransactions->sum('amount');
                $po->remaining_balance = $po->total_amount - $totalPaid;
                $po->paid_amount_total = $totalPaid;
                return $po;
            })
            ->filter(function($po) {
                return $po->remaining_balance > 0;
            })
            ->values();
        
        // Fetch accounting transactions for the table
        $transactions = Accounting::with(['salesOrder.customer', 'purchaseOrder.supplier'])
            ->orderBy('date', 'desc')
            ->get();

        return view('Systems.accounting', compact('totalRevenue', 'totalExpenses', 'netProfit', 'lastMonthRevenuePercentage', 'lastMonthNetProfitPercentage', 'lastMonthExpensesPercentage', 'salesOrders', 'purchaseOrders', 'transactions'));
    }

    public function addTransaction( SalesOrder $salesOrder, PurchaseOrder $purchaseOrder )
    {
            


        return view('Systems.add_transaction');
    }

    public function salesTransaction(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|in:Income,Expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reference' => 'required|string',
            'order_id' => 'required|numeric',
            'description' => 'nullable|string|max:500',
        ]);

        // For Income (Sales Orders)
        if ($request->transaction_type === 'Income') {
            $salesOrder = SalesOrder::findOrFail($request->order_id);
            $amountToPay = (float) $request->input('amount');
            $totalAmount = (float) $salesOrder->total_amount;

            // Check existing payments
            $existingPaid = (float) Accounting::where('sales_order_id', $request->order_id)
                ->where('transaction_type', 'Income')
                ->sum('amount');
            $newTotalPaid = $existingPaid + $amountToPay;

            // Validate that payment amount doesn't exceed total amount
            if ($newTotalPaid > $totalAmount) {
                return redirect()->back()->withErrors([
                    'amount' => "Payment amount exceeds the remaining balance of ₱" . number_format(max($totalAmount - $existingPaid, 0), 2)
                ]);
            }

            // Create the transaction (don't delete previous ones!)
            Accounting::create([
                'transaction_type' => 'Income',
                'amount' => $amountToPay,
                'date' => $request->input('date'),
                'description' => $request->input('description'),
                'sales_order_id' => $request->order_id,
                'purchase_order_id' => null,
            ]);

            // Update payment status for sales order
            $totalPaid = (float) Accounting::where('sales_order_id', $request->order_id)
                ->where('transaction_type', 'Income')
                ->sum('amount');

            $paymentStatus = $totalPaid >= $totalAmount ? 'Paid' : 'Partial';
            $salesOrder->update(['payment_status' => $paymentStatus]);
        }
        // For Expense (Purchase Orders)
        elseif ($request->transaction_type === 'Expense') {
            $purchaseOrder = PurchaseOrder::findOrFail($request->order_id);
            $amountToPay = (float) $request->input('amount');
            $totalAmount = (float) $purchaseOrder->total_amount;

            $existingPaid = (float) Accounting::where('purchase_order_id', $request->order_id)
                ->where('transaction_type', 'Expense')
                ->sum('amount');
            $newTotalPaid = $existingPaid + $amountToPay;

            // Validate that payment amount doesn't exceed total amount
            if ($newTotalPaid > $totalAmount) {
                return redirect()->back()->withErrors([
                    'amount' => "Payment amount exceeds the remaining balance of ₱" . number_format(max($totalAmount - $existingPaid, 0), 2)
                ]);
            }

            // Create the transaction
            Accounting::create([
                'transaction_type' => 'Expense',
                'amount' => $amountToPay,
                'date' => $request->input('date'),
                'description' => $request->input('description'),
                'sales_order_id' => null,
                'purchase_order_id' => $request->order_id,
            ]);

            // Update payment status for purchase order
            $totalPaid = (float) Accounting::where('purchase_order_id', $request->order_id)
                ->where('transaction_type', 'Expense')
                ->sum('amount');

            $paymentStatus = $totalPaid >= $totalAmount ? 'Paid' : 'Partial';
            $purchaseOrder->update(['payment_status' => $paymentStatus]);
        }

        return redirect()->route('accounting')->with('success', 'Transaction added successfully!');
    }

    

    public function lastMonthNetprofit($totalNetProfit) 
    {
        // Get last month's revenue
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();
        
        $lastMonthRevenue = Accounting::where('transaction_type', 'Income')
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');
        
        // Get last month's expenses
        $lastMonthExpenses = Accounting::where('transaction_type', 'Expense')
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');
        
        // Calculate last month's net profit
        $lastMonthNetProfit = $lastMonthRevenue - $lastMonthExpenses;
        
        // Calculate percentage
        $netProfitPercentage = $totalNetProfit > 0 ? ($lastMonthNetProfit / $totalNetProfit) * 100 : 0;
        
        return round($netProfitPercentage, 2);
    }

    public function lastMonthTotalExpenses($totalExpenses)
    {
        // Get last month's expenses
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();
        
        $lastMonthExpenses = Accounting::where('transaction_type', 'Expense')
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');
        
        // Calculate percentage
        $expensesPercentage = $totalExpenses > 0 ? ($lastMonthExpenses / $totalExpenses) * 100 : 0;
        
        return round($expensesPercentage, 2);
    }
    Public function lastMonthRevenue( $totalRevenue )
     {
            // Get last month's revenue from transactions
            $lastMonthStart = now()->subMonth()->startOfMonth();
            $lastMonthEnd = now()->subMonth()->endOfMonth();
            $lastMonthRevenue = Accounting::where('transaction_type', 'Income')
                ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
                ->sum('amount');
            // Calculate percentage
            $revenuePercentage = $totalRevenue > 0 ? ($lastMonthRevenue / $totalRevenue) * 100 : 0;
            return round($revenuePercentage, 2);
    }
 

    public function generateFinancialReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

       
        $financialData = [
            'total_revenue' => 0,
            'total_expenses' => 0,
            'net_profit' => 0,
        ];


        // Or get individual sales orders with their totals
        $salesOrders = SalesOrder::whereBetween('order_date', [$startDate, $endDate])
            ->get(['id', 'order_number', 'total_amount', 'order_date']);

        return view('Systems.accounting_report', compact('financialData', 'startDate', 'endDate', 'totalRevenue', 'salesOrders'));
    }

   
}
