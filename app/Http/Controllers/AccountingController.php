<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index()
    {
        return view('Systems.accounting');
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

        return view('Systems.accounting_report', compact('financialData', 'startDate', 'endDate'));
    }
}
