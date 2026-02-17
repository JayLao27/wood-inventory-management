<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\InventoryMovement;
use App\Models\Material;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\WorkOrder;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function index()
    {
        // Paginate work orders instead of loading all
        $workOrders = WorkOrder::with(['salesOrder.customer', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        // Get status counts with COUNT queries, not loading all data
        $statusCounts = [
            'pending' => WorkOrder::where('status', 'pending')->count(),
            'in_progress' => WorkOrder::where('status', 'in_progress')->count(),
            'quality_check' => WorkOrder::where('status', 'quality_check')->count(),
            'completed' => WorkOrder::where('status', 'completed')->count(),
            'overdue' => WorkOrder::where('status', 'overdue')->count(),
            'cancelled' => WorkOrder::where('status', 'cancelled')->count(),
        ];

        // Get pending sales orders with better query filtering
        // Use DB subquery instead of map/filter in PHP
        $pendingSalesOrders = SalesOrder::with(['customer', 'items.product', 'workOrders'])
            ->where('status', '!=', 'Delivered')
            ->whereHas('items', function($query) {
                // Only get orders that have items without corresponding work orders (excluding cancelled)
                $query->whereNotExists(function($subQuery) {
                    $subQuery->select(DB::raw(1))
                        ->from('work_orders')
                        ->whereColumn('work_orders.product_id', 'sales_order_items.product_id')
                        ->where('work_orders.status', '!=', 'cancelled');
                });
            })
            ->orderBy('delivery_date')
            ->paginate(15);

        $pendingItemsCount = (int) SalesOrderItem::whereHas('salesOrder', function($query) {
            $query->where('status', '!=', 'Delivered');
        })
        ->whereNotExists(function($subQuery) {
            $subQuery->select(DB::raw(1))
                ->from('work_orders')
                ->whereColumn('work_orders.product_id', 'sales_order_items.product_id')
                ->where('work_orders.status', '!=', 'cancelled');
        })
        ->count();

        // Use pending items count instead of recalculating from pending orders
        $statusCounts['pending'] = $pendingItemsCount;

        return view('Systems.production', compact('workOrders', 'statusCounts', 'pendingSalesOrders', 'pendingItemsCount'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'sales_order_id' => 'required|exists:sales_orders,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'due_date' => 'required|date',
                'assigned_to' => 'required|string|max:255',
                'priority' => 'nullable|in:low,medium,high',
            ]);

            $salesOrder = SalesOrder::with('items')->findOrFail($validated['sales_order_id']);
            $product = Product::with('materials')->findOrFail($validated['product_id']);

            // Check for existing active work order (excluding cancelled)
            $alreadyExists = WorkOrder::where('sales_order_id', $validated['sales_order_id'])
                ->where('product_id', $validated['product_id'])
                ->where('status', '!=', 'cancelled')
                ->exists();
            if ($alreadyExists) {
                $message = 'A work order for this product already exists for the selected sales order.';
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $message], 400);
                }
                return redirect()->back()->with('error', $message);
            }

            // Ensure this product/quantity is from this sales order
            $lineItem = $salesOrder->items->firstWhere('product_id', $validated['product_id']);
            if (!$lineItem || $lineItem->quantity < (int) $validated['quantity']) {
                $message = 'Invalid product or quantity for this sales order.';
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $message], 400);
                }
                return redirect()->back()->with('error', $message);
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
                    $message = sprintf(
                        'Insufficient stock for "%s". Required: %s %s, Available: %s %s.',
                        $material->name,
                        number_format($qtyNeeded, 2),
                        $material->unit,
                        number_format($material->current_stock, 2),
                        $material->unit
                    );
                    if ($request->wantsJson()) {
                        return response()->json(['success' => false, 'message' => $message], 400);
                    }
                    return redirect()->back()->with('error', $message);
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
                'status' => 'in_progress',
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

            $message = 'Work order ' . $orderNumber . ' created. Materials have been deducted from stock.';
            
            if ($request->wantsJson()) {
                $workOrder->load(['salesOrder.customer', 'product']);
                $html = view('partials.work-order-row', ['workOrder' => $workOrder])->render();

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'html' => $html
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $message = 'Validation failed: ' . implode(', ', array_reduce($e->errors(), function ($carry, $item) {
                return array_merge($carry, $item);
            }, []));
            
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            $message = 'Error creating work order: ' . $e->getMessage();
            
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 500);
            }
            return redirect()->back()->with('error', $message);
        }
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        try {
            $validated = $request->validate([
                'status' => 'nullable|in:pending,in_progress,quality_check,completed,overdue,cancelled',
                'completion_quantity' => 'nullable|integer|min:0',
                'notes' => 'nullable|string|max:1000',
            ]);

            $updateData = [];
            if (isset($validated['status'])) {
                $updateData['status'] = $validated['status'];
            }
            if (isset($validated['completion_quantity'])) {
                $updateData['completion_quantity'] = $validated['completion_quantity'];
            }
            if (isset($validated['notes'])) {
                $updateData['notes'] = $validated['notes'];
            }

            if (!empty($updateData)) {
                $workOrder->update($updateData);
            }

            $message = 'Work order updated successfully.';
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $message = 'Validation failed: ' . implode(', ', array_reduce($e->errors(), function ($carry, $item) {
                return array_merge($carry, $item);
            }, []));
            
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            $message = 'Error updating work order: ' . $e->getMessage();
            
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 500);
            }
            return redirect()->back()->with('error', $message);
        }
    }

    public function start(WorkOrder $workOrder)
    {
        if ($workOrder->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending work orders can be started.');
        }
        $workOrder->update([
            'status' => 'in_progress',
            'starting_date' => now()->toDateString()
        ]);
        return redirect()->back()->with('success', 'Work order started.');
    }

    public function complete(WorkOrder $workOrder, Request $request)
    {
        if ($workOrder->status === 'completed') {
            $message = 'Work order is already completed.';
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 400);
            }
            return redirect()->back()->with('info', $message);
        }
        
        $workOrder->update([
            'status' => 'completed',
            'completion_quantity' => $workOrder->quantity,
        ]);

        $workOrder->loadMissing('product');
        $laborCost = 0;
        if ($workOrder->product) {
            $qty = $workOrder->completion_quantity > 0 ? $workOrder->completion_quantity : $workOrder->quantity;
            $laborCost = (float) $workOrder->product->production_cost * (int) $qty;
        }

        if ($laborCost > 0) {
            $laborRef = 'Labor - Work Order ' . $workOrder->order_number;
            $alreadyRecorded = Accounting::where('transaction_type', 'Expense')
                ->where('description', $laborRef)
                ->exists();

            if (!$alreadyRecorded) {
                Accounting::create([
                    'transaction_type' => 'Expense',
                    'amount' => $laborCost,
                    'date' => now()->toDateString(),
                    'description' => $laborRef,
                    'sales_order_id' => $workOrder->sales_order_id,
                    'purchase_order_id' => null,
                ]);
            }
        }
        
        $message = 'Work order marked as completed.';
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }

    public function cancel(WorkOrder $workOrder)
    {
        try {
            if ($workOrder->status === 'completed' || $workOrder->status === 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot cancel a completed or already cancelled work order.'
                ], 400);
            }

            $workOrder->update([
                'status' => 'cancelled',
                'completion_quantity' => 0,
            ]);

            // Release reserved materials back to inventory
            if ($workOrder->product && $workOrder->product->materials) {
                foreach ($workOrder->product->materials as $material) {
                    $qtyToRelease = (float) $material->pivot->quantity_needed * (int) $workOrder->quantity;
                    $material->increment('current_stock', $qtyToRelease);

                    // Record the inventory movement
                    InventoryMovement::create([
                        'item_type' => 'App\Models\Material',
                        'item_id' => $material->id,
                        'movement_type' => 'Return',
                        'quantity' => $qtyToRelease,
                        'reference_type' => 'App\Models\WorkOrder',
                        'reference_id' => $workOrder->id,
                        'notes' => 'Materials released from cancelled work order ' . $workOrder->order_number,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Work order cancelled successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling work order: ' . $e->getMessage()
            ], 500);
        }
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
