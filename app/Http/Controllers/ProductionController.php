<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        // Get work orders with sample data
        $workOrders = WorkOrder::all();
        
        // If no work orders exist, create sample data
        if ($workOrders->isEmpty()) {
            $sampleOrders = [
                [
                    'order_number' => 'WO-2025-001',
                    'product_name' => 'Classic Oak Dining Chair',
                    'quantity' => 4,
                    'completion_quantity' => 1,
                    'status' => 'in_progress',
                    'due_date' => '2025-01-25',
                    'assigned_to' => 'Workshop Team A',
                    'priority' => 'high'
                ],
                [
                    'order_number' => 'WO-2025-002',
                    'product_name' => 'Pine Coffee Table',
                    'quantity' => 2,
                    'completion_quantity' => 0,
                    'status' => 'pending',
                    'due_date' => '2025-02-05',
                    'assigned_to' => 'Workshop Team A',
                    'priority' => 'medium'
                ],
                [
                    'order_number' => 'WO-2025-003',
                    'product_name' => 'Oak Kitchen Cabinet',
                    'quantity' => 1,
                    'completion_quantity' => 1,
                    'status' => 'completed',
                    'due_date' => '2025-02-22',
                    'assigned_to' => 'Workshop Team A',
                    'priority' => 'medium'
                ],
                [
                    'order_number' => 'WO-2025-004',
                    'product_name' => 'Pine Bookshelf',
                    'quantity' => 3,
                    'completion_quantity' => 3,
                    'status' => 'completed',
                    'due_date' => '2025-01-18',
                    'assigned_to' => 'Workshop Team A',
                    'priority' => 'low'
                ],
                [
                    'order_number' => 'WO-2025-005',
                    'product_name' => 'Oak Dining Table',
                    'quantity' => 1,
                    'completion_quantity' => 0,
                    'status' => 'overdue',
                    'due_date' => '2025-01-20',
                    'assigned_to' => 'Workshop Team A',
                    'priority' => 'high'
                ]
            ];

            foreach ($sampleOrders as $order) {
                WorkOrder::create($order);
            }
            
            $workOrders = WorkOrder::all();
        }

        // Calculate status counts
        $statusCounts = [
            'pending' => $workOrders->where('status', 'pending')->count(),
            'in_progress' => $workOrders->where('status', 'in_progress')->count(),
            'quality_check' => $workOrders->where('status', 'quality_check')->count(),
            'completed' => $workOrders->where('status', 'completed')->count(),
            'overdue' => $workOrders->where('status', 'overdue')->count()
        ];

        return view('Systems.production', compact('workOrders', 'statusCounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'due_date' => 'required|date|after:today',
            'assigned_to' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'notes' => 'nullable|string'
        ]);

        // Generate order number
        $lastOrder = WorkOrder::orderBy('id', 'desc')->first();
        $orderNumber = 'WO-' . date('Y') . '-' . str_pad(($lastOrder ? $lastOrder->id + 1 : 1), 3, '0', STR_PAD_LEFT);

        WorkOrder::create([
            'order_number' => $orderNumber,
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'priority' => $request->priority,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect()->route('production')->with('success', 'Work order created successfully!');
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,quality_check,completed,overdue',
            'completion_quantity' => 'required|integer|min:0|max:' . $workOrder->quantity
        ]);

        $workOrder->update([
            'status' => $request->status,
            'completion_quantity' => $request->completion_quantity
        ]);

        return redirect()->route('production')->with('success', 'Work order updated successfully!');
    }
}