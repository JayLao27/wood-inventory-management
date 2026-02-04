<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Material;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::with(['salesOrder.customer', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $statusCounts = [
            'pending' => $workOrders->where('status', 'pending')->count(),
            'in_progress' => $workOrders->where('status', 'in_progress')->count(),
            'quality_check' => $workOrders->where('status', 'quality_check')->count(),
            'completed' => $workOrders->where('status', 'completed')->count(),
            'overdue' => $workOrders->where('status', 'overdue')->count(),
        ];

        // Pending sales orders: not Delivered, with only items that don't already have work orders
        $pendingSalesOrders = SalesOrder::with(['customer', 'items.product', 'workOrders'])
            ->where('status', '!=', 'Delivered')
            ->orderBy('delivery_date')
            ->get()
            ->map(function (SalesOrder $order) {
                $remainingItems = $order->items->filter(function ($item) use ($order) {
                    return !$order->workOrders->contains('product_id', $item->product_id);
                })->values();

                $order->setRelation('items', $remainingItems);
                return $order;
            })
            ->filter(function (SalesOrder $order) {
                return $order->items->isNotEmpty();
            })
            ->values();

        return view('Systems.production', compact('workOrders', 'statusCounts', 'pendingSalesOrders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sales_order_id' => 'required|exists:sales_orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'due_date' => 'required|date|after_or_equal:today',
            'assigned_to' => 'required|string|max:255',
            'priority' => 'nullable|in:low,medium,high',
        ]);

        $salesOrder = SalesOrder::with('items')->findOrFail($validated['sales_order_id']);
        $product = Product::with('materials')->findOrFail($validated['product_id']);

        $alreadyExists = WorkOrder::where('sales_order_id', $validated['sales_order_id'])
            ->where('product_id', $validated['product_id'])
            ->exists();
        if ($alreadyExists) {
            return redirect()->back()->with('error', 'A work order for this product already exists for the selected sales order.');
        }

        // Ensure this product/quantity is from this sales order
        $lineItem = $salesOrder->items->firstWhere('product_id', $validated['product_id']);
        if (!$lineItem || $lineItem->quantity < (int) $validated['quantity']) {
            return redirect()->back()->with('error', 'Invalid product or quantity for this sales order.');
        }

        // Check material availability (BOM) and reserve / deduct
        $materialsNeeded = [];
        foreach ($product->materials as $material) {
            $qtyNeeded = (float) $material->pivot->quantity_needed * (int) $validated['quantity'];
            $materialsNeeded[] = [
                'material' => $material,
                'quantity_needed' => $qtyNeeded,
            ];
        }

        foreach ($materialsNeeded as $entry) {
            $material = $entry['material'];
            $qtyNeeded = $entry['quantity_needed'];
            if ($material->current_stock < $qtyNeeded) {
                return redirect()->back()->with('error', sprintf(
                    'Insufficient stock for "%s". Required: %s %s, Available: %s %s.',
                    $material->name,
                    number_format($qtyNeeded, 2),
                    $material->unit,
                    number_format($material->current_stock, 2),
                    $material->unit
                ));
            }
        }

        $orderNumber = $this->generateWorkOrderNumber();

        $workOrder = WorkOrder::create([
            'order_number' => $orderNumber,
            'sales_order_id' => $validated['sales_order_id'],
            'product_id' => $validated['product_id'],
            'product_name' => $product->product_name,
            'quantity' => (int) $validated['quantity'],
            'due_date' => $validated['due_date'],
            'assigned_to' => $validated['assigned_to'],
            'priority' => $validated['priority'] ?? 'medium',
            'status' => 'pending',
        ]);

        // Stock out: create inventory movements (out) and deduct material stock
        foreach ($materialsNeeded as $entry) {
            $material = $entry['material'];
            $qtyNeeded = $entry['quantity_needed'];

            InventoryMovement::create([
                'item_type' => 'material',
                'item_id' => $material->id,
                'movement_type' => 'out',
                'quantity' => $qtyNeeded,
                'reference_type' => WorkOrder::class,
                'reference_id' => $workOrder->id,
                'notes' => sprintf('Production work order %s – %s x %s', $workOrder->order_number, $product->product_name, $validated['quantity']),
                'status' => 'completed',
            ]);

            $material->decrement('current_stock', $qtyNeeded);
        }

        return redirect()->back()->with('success', 'Work order ' . $orderNumber . ' created. Materials have been deducted from stock.');
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,quality_check,completed,overdue',
            'completion_quantity' => 'nullable|integer|min:0',
        ]);

        $workOrder->update([
            'status' => $validated['status'],
            'completion_quantity' => $validated['completion_quantity'] ?? $workOrder->completion_quantity,
        ]);

        return redirect()->back()->with('success', 'Work order updated.');
    }

    public function start(WorkOrder $workOrder)
    {
        if ($workOrder->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending work orders can be started.');
        }
        $workOrder->update(['status' => 'in_progress']);
        return redirect()->back()->with('success', 'Work order started.');
    }

    public function complete(WorkOrder $workOrder)
    {
        if (!in_array($workOrder->status, ['in_progress', 'quality_check'])) {
            return redirect()->back()->with('success', 'Work order status updated.');
        }
        $workOrder->update([
            'status' => 'completed',
            'completion_quantity' => $workOrder->quantity,
        ]);
        return redirect()->back()->with('success', 'Work order marked as completed.');
    }

    private function generateWorkOrderNumber(): string
    {
        $year = now()->format('Y');
        $prefix = 'WO-' . $year . '-';

        $last = WorkOrder::where('order_number', 'like', $prefix . '%')
            ->orderBy('order_number', 'desc')
            ->value('order_number');

        $nextSeq = 1;
        if ($last) {
            $parts = explode('-', $last);
            $seqPart = end($parts);
            $num = (int) ltrim($seqPart, '0');
            $nextSeq = $num + 1;
        }

        do {
            $candidate = sprintf('%s%03d', $prefix, $nextSeq);
            $exists = WorkOrder::where('order_number', $candidate)->exists();
            if (!$exists) {
                return $candidate;
            }
            $nextSeq++;
        } while (true);
    }
}
