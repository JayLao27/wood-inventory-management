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
        
        // Fetch sales orders and purchase orders for the transaction modal
        $existingSalesOrderIds = Accounting::whereNotNull('sales_order_id')->pluck('sales_order_id');
        $existingPurchaseOrderIds = Accounting::whereNotNull('purchase_order_id')->pluck('purchase_order_id');

        $salesOrders = SalesOrder::with('customer')
            ->whereNotIn('id', $existingSalesOrderIds)
            ->orderBy('order_date', 'desc')
            ->get();
        
        // Only show purchase orders that have received stock (have inventory movements)
        $purchaseOrders = PurchaseOrder::with('supplier')
            ->whereNotIn('id', $existingPurchaseOrderIds)
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
            ->get();
        
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

        if ($request->transaction_type === 'Income') {
            Accounting::where('sales_order_id', $request->order_id)->delete();
        }

        if ($request->transaction_type === 'Expense') {
            Accounting::where('purchase_order_id', $request->order_id)->delete();
            // Get purchase order and calculate payment status based on amount
            $purchaseOrder = PurchaseOrder::findOrFail($request->order_id);
            $amountToPay = $request->input('amount');
            $totalAmount = $purchaseOrder->total_amount;
            
            // Validate that payment amount doesn't exceed total amount
            if ($amountToPay > $totalAmount) {
                return redirect()->back()->withErrors(['amount' => "Payment amount cannot exceed the total order amount of ₱" . number_format($totalAmount, 2)]);
            }
            
            // Determine payment status - only Paid or Partial (no Pending)
            if ($amountToPay >= $totalAmount) {
                $paymentStatus = 'Paid';
            } else {
                $paymentStatus = 'Partial';
            }
            
            $purchaseOrder->update(['payment_status' => $paymentStatus]);
        }

        Accounting::create([
            'transaction_type' => $request->input('transaction_type'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
            'sales_order_id' => $request->transaction_type === 'Income' ? $request->order_id : null,
            'purchase_order_id' => $request->transaction_type === 'Expense' ? $request->order_id : null,
        ]);

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
