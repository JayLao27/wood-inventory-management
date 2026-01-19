<?php

namespace App\Http\Controllers;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;  
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index()
    {
        $totalRevenue = SalesOrder::sum('total_amount');
        
        return view('Systems.accounting', compact('totalRevenue'));
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

        // Get total revenue from all sales orders within a date range
        $totalRevenue = SalesOrder::whereBetween('order_date', [$startDate, $endDate])
            ->sum('total_amount');

        // Or get individual sales orders with their totals
        $salesOrders = SalesOrder::whereBetween('order_date', [$startDate, $endDate])
            ->get(['id', 'order_number', 'total_amount', 'order_date']);

        return view('Systems.accounting_report', compact('financialData', 'startDate', 'endDate', 'totalRevenue', 'salesOrders'));
    }
}
