<?php

namespace App\Http\Controllers;
use App\Models\Accounting;
use App\Models\Customer;
use App\Models\Material;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\WorkOrder;
use Carbon\Carbon;
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

        // Fetch purchase orders first to calculate pending materials
        $allPurchaseOrders = PurchaseOrder::with(['supplier', 'accountingTransactions' => function($query) {
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
            });

        // Expense Breakdown - Materials (pending/unpaid only) + Labor (already paid)
        $materialsExpense = (float) $allPurchaseOrders
            ->filter(function($po) {
                return $po->remaining_balance > 0;
            })
            ->sum('remaining_balance');

        $laborExpense = (float) Accounting::where('transaction_type', 'Expense')
            ->where('description', 'like', 'Labor - Work Order%')
            ->sum('amount');

        $totalBreakdown = $materialsExpense + $laborExpense;
        $materialsPercent = ($materialsExpense / 10000) * 100;
        $laborPercent = ($laborExpense / 10000) * 100;
        
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
        $purchaseOrders = $allPurchaseOrders
            ->filter(function($po) {
                return $po->remaining_balance > 0;
            })
            ->values();
        
        // Fetch accounting transactions for the table
        $transactions = Accounting::with(['salesOrder.customer', 'purchaseOrder.supplier'])
            ->orderBy('date', 'desc')
            ->get();

        return view('Systems.accounting', compact(
            'totalRevenue',
            'totalExpenses',
            'netProfit',
            'lastMonthRevenuePercentage',
            'lastMonthNetProfitPercentage',
            'lastMonthExpensesPercentage',
            'salesOrders',
            'purchaseOrders',
            'transactions',
            'materialsExpense',
            'laborExpense',
            'materialsPercent',
            'laborPercent'
        ));
    }

    public function dashboard()
    {
        $salesOrders = SalesOrder::with(['customer', 'items.product'])->latest()->get();
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('product_name')->get();

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();

        // Revenue & income (from accounting transactions)
        $totalRevenue = (float) Accounting::where('transaction_type', 'Income')->sum('amount');
        $revenueThisMonth = (float) Accounting::where('transaction_type', 'Income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        $revenueLastMonth = (float) Accounting::where('transaction_type', 'Income')
            ->whereBetween('date', [$startOfLastMonth, $endOfLastMonth])
            ->sum('amount');
        $income = $totalRevenue; // income = revenue from accounting

        $revenueChangePercent = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
            : ($revenueThisMonth > 0 ? 100 : 0);

        // Expenses (from accounting transactions)
        $totalExpenses = (float) Accounting::where('transaction_type', 'Expense')->sum('amount');
        $expensesThisMonth = (float) Accounting::where('transaction_type', 'Expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        $expensesLastMonth = (float) Accounting::where('transaction_type', 'Expense')
            ->whereBetween('date', [$startOfLastMonth, $endOfLastMonth])
            ->sum('amount');
        $expensesChangePercent = $expensesLastMonth > 0
            ? round((($expensesThisMonth - $expensesLastMonth) / $expensesLastMonth) * 100, 1)
            : ($expensesThisMonth > 0 ? 100 : 0);

        // Net profit
        $netProfit = $totalRevenue - $totalExpenses;
        $netProfitThisMonth = $revenueThisMonth - $expensesThisMonth;
        $netProfitLastMonth = $revenueLastMonth - $expensesLastMonth;
        $netProfitChangePercent = $netProfitLastMonth != 0
            ? round((($netProfitThisMonth - $netProfitLastMonth) / abs($netProfitLastMonth)) * 100, 1)
            : ($netProfitThisMonth != 0 ? 100 : 0);

        // In production (work orders)
        $inProductionCount = WorkOrder::whereIn('status', ['in_progress', 'quality_check'])->count();
        $overdueWorkOrders = WorkOrder::whereNotIn('status', ['completed'])
            ->where('due_date', '<', $now->toDateString())
            ->count();

        // Active/new orders
        $activeOrdersCount = SalesOrder::whereIn('status', ['Pending', 'In production', 'Ready'])->count();
        $newOrdersThisWeek = SalesOrder::whereDate('order_date', '>=', $startOfWeek)->count();

        // Low stock (materials + products)
        $lowStockMaterials = Material::whereRaw('current_stock <= minimum_stock')->orderBy('current_stock')->get();
        $lowStockCount = $lowStockMaterials->count();

        // Accounting report: last 6 months by month (based only on accounting transactions)
        $accountingTransactions = Accounting::select('transaction_type', 'amount', 'date')->get();
        $salesReportMonths = collect();
        $salesReportRevenue = collect();
        $salesReportExpenses = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();
            $salesReportMonths->push($month->format('M Y'));
            $salesReportRevenue->push((float) $accountingTransactions
                ->filter(fn ($tx) => $tx->transaction_type === 'Income' && $tx->date && $tx->date->between($start, $end))
                ->sum('amount'));
            $salesReportExpenses->push((float) $accountingTransactions
                ->filter(fn ($tx) => $tx->transaction_type === 'Expense' && $tx->date && $tx->date->between($start, $end))
                ->sum('amount'));
        }

        // Chart data (last 6 months)
        $chartLabels = $salesReportMonths->toArray();
        $chartRevenue = $salesReportRevenue->toArray();
        $chartExpenses = $salesReportExpenses->toArray();
        $chartProfit = $salesReportRevenue->zip($salesReportExpenses)->map(fn ($p) => $p[0] - $p[1])->values()->toArray();

        return view('Systems.dashboard', compact(
            'salesOrders',
            'customers',
            'products',
            'totalRevenue',
            'revenueChangePercent',
            'income',
            'totalExpenses',
            'expensesChangePercent',
            'netProfit',
            'netProfitChangePercent',
            'activeOrdersCount',
            'newOrdersThisWeek',
            'inProductionCount',
            'overdueWorkOrders',
            'lowStockCount',
            'lowStockMaterials',
            'chartLabels',
            'chartRevenue',
            'chartExpenses',
            'chartProfit',
            'salesReportMonths',
            'salesReportRevenue',
            'salesReportExpenses'
        ));
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

    public function exportTransactionReceipt($transactionId)
    {
        // Extract the actual ID from the format TO-YYYY-XXX
        $parts = explode('-', $transactionId);
        $id = isset($parts[2]) ? (int)$parts[2] : null;
        
        if (!$id) {
            abort(404, 'Invalid transaction ID');
        }

        $transaction = Accounting::with(['salesOrder.customer', 'purchaseOrder.supplier'])
            ->findOrFail($id);

        return view('exports.transaction-receipt', compact('transaction', 'transactionId'));
    }

    public function exportFinancialReport()
    {
        $totalRevenue = Accounting::where('transaction_type', 'Income')->sum('amount');
        $totalExpenses = Accounting::where('transaction_type', 'Expense')->sum('amount');
        $netProfit = $totalRevenue - $totalExpenses;

        $filename = 'financial-report-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($totalRevenue, $totalExpenses, $netProfit) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['Financial Report', 'Generated on ' . now()->format('F d, Y')]);
            fputcsv($file, []);
            fputcsv($file, ['Metric', 'Amount']);
            
            // CSV Data
            fputcsv($file, ['Total Revenue', number_format($totalRevenue, 2)]);
            fputcsv($file, ['Total Expenses', number_format($totalExpenses, 2)]);
            fputcsv($file, ['Net Profit', number_format($netProfit, 2)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportTransactionHistory()
    {
        $transactions = Accounting::with(['salesOrder.customer', 'purchaseOrder.supplier'])
            ->orderBy('date', 'desc')
            ->get();

        $filename = 'transactions-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Transaction ID',
                'Date',
                'Type',
                'Category',
                'Description',
                'Amount',
            ]);

            // CSV Data
            foreach ($transactions as $transaction) {
                $transactionId = 'TO-' . \Carbon\Carbon::parse($transaction->date)->format('Y') . '-' . str_pad($transaction->id, 3, '0', STR_PAD_LEFT);
                $category = '';
                $description = '';

                if ($transaction->salesOrder) {
                    $category = $transaction->salesOrder->customer->name ?? 'N/A';
                    $description = $transaction->salesOrder->order_number ?? '';
                } elseif ($transaction->purchaseOrder) {
                    $category = $transaction->purchaseOrder->supplier->name ?? 'N/A';
                    $description = $transaction->purchaseOrder->order_number ?? '';
                } else {
                    $category = 'N/A';
                    $description = $transaction->description ?? '-';
                }

                fputcsv($file, [
                    $transactionId,
                    \Carbon\Carbon::parse($transaction->date)->format('M d, Y'),
                    $transaction->transaction_type,
                    $category,
                    $description,
                    number_format($transaction->amount, 2),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
   
}
