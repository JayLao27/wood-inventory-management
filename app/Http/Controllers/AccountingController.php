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
        $totalRevenue = SalesOrderItem::selectRaw('SUM(Quantity * unit_price) as total')->pluck('total')->first();
        $totalExpenses = PurchaseOrder::sum('total_amount');
        $netProfit = $totalRevenue - $totalExpenses;
        $lastMonthRevenuePercentage = $this->lastMonthRevenue($totalRevenue);
        $lastMonthNetProfitPercentage = $this->lastMonthNetprofit($netProfit);
        $lastMonthExpensesPercentage = $this->lastMonthTotalExpenses($totalExpenses);
        
        // Fetch sales orders and purchase orders for the transaction modal
        $salesOrders = SalesOrder::with('customer')->orderBy('order_date', 'desc')->get();
        $purchaseOrders = PurchaseOrder::with('supplier')->orderBy('order_date', 'desc')->get();
        
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
        
        $lastMonthRevenue = SalesOrderItem::whereBetween(
            SalesOrderItem::raw('DATE(created_at)'),
            [$lastMonthStart, $lastMonthEnd]
        )->selectRaw('SUM(Quantity * unit_price) as total')->pluck('total')->first();
        
        // Get last month's expenses
        $lastMonthExpenses = PurchaseOrder::whereBetween(
            PurchaseOrder::raw('DATE(order_date)'),
            [$lastMonthStart, $lastMonthEnd]
        )->sum('total_amount');
        
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
        
        $lastMonthExpenses = PurchaseOrder::whereBetween(
            PurchaseOrder::raw('DATE(order_date)'),
            [$lastMonthStart, $lastMonthEnd]
        )->sum('total_amount');
        
        // Calculate percentage
        $expensesPercentage = $totalExpenses > 0 ? ($lastMonthExpenses / $totalExpenses) * 100 : 0;
        
        return round($expensesPercentage, 2);
    }
    Public function lastMonthRevenue( $totalRevenue )
     {
            // Get last month's revenue
            $lastMonthStart = now()->subMonth()->startOfMonth();
            $lastMonthEnd = now()->subMonth()->endOfMonth();
            $lastMonthRevenue = SalesOrderItem::whereBetween(
            SalesOrderItem::raw('DATE(created_at)'),
            [$lastMonthStart, $lastMonthEnd]
            )->selectRaw('SUM(Quantity * unit_price) as total')->pluck('total')->first();
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
