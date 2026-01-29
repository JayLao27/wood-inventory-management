<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
       
        $workOrders = collect();

        $statusCounts = [
            'pending' => 0,
            'in_progress' => 0,
            'quality_check' => 0,
            'completed' => 0,
            'overdue' => 0,
        ];

        $pendingSalesOrders = collect();

        return view('Systems.production', compact('workOrders', 'statusCounts', 'pendingSalesOrders'));
    }

    public function store(Request $request)
    {
        return redirect()->back();
    }

    public function update(Request $request, $workOrder)
    {
        return redirect()->back();
    }

    public function start($workOrder)
    {
        return redirect()->back();
    }

    public function complete($workOrder)
    {
        return redirect()->back();
    }
}
