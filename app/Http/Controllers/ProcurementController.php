<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Material;
use App\Models\InventoryMovement;
use App\Models\Accounting;

class ProcurementController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $purchaseOrders = PurchaseOrder::with(['supplier', 'items'])->get();
        $materials = Material::all();
        
        $totalSpent = PurchaseOrder::sum('total_amount');
        $activeSuppliers = Supplier::where('status', 'active')->count();
        $lowStockAlerts = Material::whereRaw('current_stock <= minimum_stock')->count();

        // Sync payment status from accounting transactions
        $purchaseOrders->each(function ($order) {
            $totalPaid = (float) Accounting::where('purchase_order_id', $order->id)
                ->where('transaction_type', 'Expense')
                ->sum('amount');

            if ($totalPaid > 0) {
                $newStatus = $totalPaid >= (float) $order->total_amount ? 'Paid' : 'Partial';
                if ($order->payment_status !== $newStatus) {
                    $order->payment_status = $newStatus;
                    $order->save();
                }
            }
        });

        $paymentsMade = $purchaseOrders->where('payment_status', 'Paid')->sum('total_amount');
        $pendingPayments = $purchaseOrders->whereIn('payment_status', ['Pending', 'Partial'])->sum('total_amount');

        // Only show purchase orders that still have remaining quantity to receive
        // Filter out POs where ALL items have been fully received or status is 'received'
        $openPurchaseOrders = $purchaseOrders->filter(function ($order) {
            // Exclude POs that are already marked as 'received'
            if (strtolower($order->status) === 'received') {
                return false;
            }
            
            // A PO is "open" if ANY of its items still has remaining quantity
            // If the order has no items, exclude it
            if ($order->items->isEmpty()) {
                return false;
            }
            
            // Check if at least one item has remaining quantity
            $hasRemainingItems = $order->items->contains(function ($item) use ($order) {
                $ordered = (float) $item->quantity;

                $alreadyReceived = (float) InventoryMovement::where('item_type', 'material')
                    ->where('item_id', $item->material_id)
                    ->where('reference_type', 'purchase_order')
                    ->where('reference_id', $order->id)
                    ->where('movement_type', 'in')
                    ->sum('quantity');

                $remaining = $ordered - $alreadyReceived;
                return $remaining > 0.001; // Use small threshold to account for floating point precision
            });
            
            return $hasRemainingItems;
        })->values();
        
        return view('Systems.procurement', compact(
            'suppliers',
            'purchaseOrders',
            'materials',
            'totalSpent',
            'paymentsMade',
            'pendingPayments',
            'activeSuppliers',
            'lowStockAlerts',
            'openPurchaseOrders'
        ));
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'payment_terms' => 'required|string|max:100',
        ]);

        Supplier::create($request->all());

        return redirect()->route('procurement')->with('success', 'Supplier added successfully!');
    }

    public function storePurchaseOrder(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.material_id' => 'required|exists:materials,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Generate order number
        $lastOrder = PurchaseOrder::orderBy('id', 'desc')->first();
        $orderNumber = 'PO-' . date('Y') . '-' . str_pad(($lastOrder ? $lastOrder->id + 1 : 1), 3, '0', STR_PAD_LEFT);

        $purchaseOrder = PurchaseOrder::create([
            'order_number' => $orderNumber,
            'supplier_id' => $request->supplier_id,
            'order_date' => $request->order_date,
            'expected_delivery' => $request->expected_delivery,
            'status' => 'Pending',
            'payment_status' => 'Pending',
            'total_amount' => 0,
        ]);

        $totalAmount = 0;
        foreach ($request->items as $item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $totalAmount += $lineTotal;
            
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'material_id' => $item['material_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $lineTotal,
            ]);
        }

        $purchaseOrder->update(['total_amount' => $totalAmount]);

        return redirect()->route('procurement')->with('success', 'Purchase order created successfully!');
    }

    public function updateSupplier(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'payment_terms' => 'required|string|max:100',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('procurement')->with('success', 'Supplier updated successfully!');
    }

    public function updatePurchaseOrder(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Delivered,Overdue',
            'payment_status' => 'required|in:Pending,Partial,Paid',
        ]);

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->update($request->only(['status', 'payment_status']));

        return redirect()->route('procurement')->with('success', 'Purchase order updated successfully!');
    }

    public function removeSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('procurement')->with('success', 'Supplier deleted successfully!');
    }

    public function destroyPurchaseOrder($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->items()->delete();
        $purchaseOrder->delete();

        return redirect()->route('procurement')->with('success', 'Purchase order deleted successfully!');
    }

    /**
     * Return purchase order items with ordered and already received quantities
     * for the Receive Stock modal.
     */
    public function getPurchaseOrderItems(Request $request, $purchaseOrderId)
    {
        $purchaseOrder = PurchaseOrder::with(['items.material'])->findOrFail($purchaseOrderId);

        $items = $purchaseOrder->items->map(function ($item) use ($purchaseOrder) {
            $ordered = (float) $item->quantity;

            $alreadyReceived = (float) InventoryMovement::where('item_type', 'material')
                ->where('item_id', $item->material_id)
                ->where('reference_type', 'purchase_order')
                ->where('reference_id', $purchaseOrder->id)
                ->where('movement_type', 'in')
                ->sum('quantity');

            $remaining = max($ordered - $alreadyReceived, 0);

            return [
                'id' => $item->id,
                'material_id' => $item->material_id,
                'material_name' => $item->material?->name ?? 'Material',
                'unit' => $item->material?->unit ?? '',
                'ordered_quantity' => $ordered,
                'already_received' => $alreadyReceived,
                'remaining_quantity' => $remaining,
                'unit_price' => (float) $item->unit_price,
                'total_amount' => (float) ($ordered * (float) $item->unit_price),
            ];
        });

        if (!$request->boolean('include_received')) {
            $items = $items->filter(function ($item) {
                // Only show items that still have remaining quantity to receive
                return $item['remaining_quantity'] > 0;
            })->values();
        } else {
            $items = $items->values();
        }

        return response()->json([
            'success' => true,
            'items' => $items,
            'order' => [
                'order_number' => $purchaseOrder->order_number,
                'supplier_name' => $purchaseOrder->supplier?->name,
            ],
        ]);
    }

    /**
     * Receive stock for a purchase order and update material inventory.
     *
     * Defect quantity is subtracted from the remaining quantity, and only the
     * net quantity is stocked in.
     */
    public function receiveStock(Request $request, $purchaseOrderId)
    {
        // Exception 1.1: Check if PO exists
        $purchaseOrder = PurchaseOrder::with('items')->find($purchaseOrderId);
        
        if (!$purchaseOrder) {
            Log::warning('Invalid PO attempt', [
                'po_id' => $purchaseOrderId,
                'user_id' => auth()->id() ?? 'Guest',
                'timestamp' => now(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid PO. Purchase order not found.',
            ], 404);
        }

        $request->validate([
            'received_date' => 'required|date',
            'items' => 'required|array',
            'items.*.purchase_order_item_id' => 'required|exists:purchase_order_items,id',
            'items.*.defect_quantity' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Exception 2.1: Multiple receipts allowed (for defect replacements, partial deliveries, etc.)
        // No duplicate check - users can receive additional quantities on the same day
        $receivedDate = $request->input('received_date');

        // Exception 2.2: Database retry logic with error logging
        $maxAttempts = 3;
        $attempt = 0;
        $success = false;
        $lastError = null;

        while ($attempt < $maxAttempts && !$success) {
            $attempt++;
            try {
                DB::transaction(function () use ($request, $purchaseOrder) {
            foreach ($request->items as $itemData) {
                $poItem = $purchaseOrder->items->firstWhere('id', $itemData['purchase_order_item_id'] ?? null);

                if (!$poItem) {
                    continue;
                }

                $ordered = (float) $poItem->quantity;

                $alreadyReceived = (float) InventoryMovement::where('item_type', 'material')
                    ->where('item_id', $poItem->material_id)
                    ->where('reference_type', 'purchase_order')
                    ->where('reference_id', $purchaseOrder->id)
                    ->where('movement_type', 'in')
                    ->sum('quantity');

                $remaining = max($ordered - $alreadyReceived, 0);

                if ($remaining <= 0) {
                    continue;
                }

                $defect = isset($itemData['defect_quantity']) ? (float) $itemData['defect_quantity'] : 0.0;

                if ($defect < 0) {
                    $defect = 0.0;
                }

                if ($defect > $remaining) {
                    $defect = $remaining;
                }

                // Net quantity that will be added to stock
                $toReceive = $remaining - $defect;

                if ($toReceive <= 0) {
                    continue;
                }

                $material = Material::findOrFail($poItem->material_id);

                // ⭐ Stock IN Record with timestamps
                InventoryMovement::create([
                    'item_type' => 'material',
                    'item_id' => $material->id,
                    'movement_type' => 'in',
                    'quantity' => $toReceive,
                    'reference_type' => 'purchase_order',
                    'reference_id' => $purchaseOrder->id,
                    'notes' => 'Received from PO ' . $purchaseOrder->order_number 
                        . ' | Received by: ' . (auth()->user()->name ?? 'System')
                        . ' | Defect Qty: ' . number_format($defect, 2),
                    // created_at is automatically set by Laravel to NOW()
                    // This captures the exact timestamp when inventory clerk records receipt
                ]);

                $material->increment('current_stock', $toReceive);
            }

            // If everything is fully received, mark the purchase order as delivered
            $allFullyReceived = $purchaseOrder->items->every(function ($item) use ($purchaseOrder) {
                $ordered = (float) $item->quantity;

                $received = (float) InventoryMovement::where('item_type', 'material')
                    ->where('item_id', $item->material_id)
                    ->where('reference_type', 'purchase_order')
                    ->where('reference_id', $purchaseOrder->id)
                    ->where('movement_type', 'in')
                    ->sum('quantity');

                return $received >= $ordered;
            });

            if ($allFullyReceived) {
                $purchaseOrder->update(['status' => 'received']);
            }
                });
                
                $success = true;
            } catch (\Exception $e) {
                $lastError = $e;
                // Log the database error
                Log::error('Database error during stock receipt (Attempt ' . $attempt . '/' . $maxAttempts . ')', [
                    'purchase_order_id' => $purchaseOrder->id,
                    'error' => $e->getMessage(),
                    'attempt' => $attempt,
                    'user_id' => auth()->id() ?? 'Guest',
                    'timestamp' => now(),
                ]);

                // Retry after a small delay
                if ($attempt < $maxAttempts) {
                    sleep(1); // Wait 1 second before retrying
                }
            }
        }

        if (!$success) {
            Log::error('Stock receipt failed after ' . $maxAttempts . ' attempts', [
                'purchase_order_id' => $purchaseOrder->id,
                'final_error' => $lastError->getMessage(),
                'user_id' => auth()->id() ?? 'Guest',
                'timestamp' => now(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to process stock receipt after multiple attempts. Please try again later.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Stock received and inventory updated successfully.',
        ]);
    }

    public function receivedStockReports(Request $request)
    {
        $query = InventoryMovement::where('movement_type', 'in')
            ->where('item_type', 'material')
            ->where('reference_type', 'purchase_order');

        // Apply date filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply material filter
        if ($request->has('material') && $request->material) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('name', $request->material);
            });
        }

        $movements = $query->orderBy('created_at', 'desc')->get();

        // Format the data for the frontend
        $formattedMovements = $movements->map(function ($movement) {
            $material = Material::find($movement->item_id);
            $purchaseOrder = PurchaseOrder::find($movement->reference_id);
            
            // Get defect quantity from notes if stored there
            $defectQty = 0;
            if ($movement->notes && preg_match('/Defect quantity: ([\d.]+)/', $movement->notes, $matches)) {
                $defectQty = (float) $matches[1];
            }

            return [
                'date' => $movement->created_at->format('Y-m-d H:i'),
                'po_number' => $purchaseOrder ? ($purchaseOrder->order_number ?? 'PO-' . str_pad($purchaseOrder->id, 6, '0', STR_PAD_LEFT)) : 'N/A',
                'material_name' => $material ? $material->name : 'Unknown',
                'quantity' => $movement->quantity,
                'defect_quantity' => $defectQty,
                'supplier_name' => $purchaseOrder && $purchaseOrder->supplier ? $purchaseOrder->supplier->name : 'N/A',
                'status' => $movement->status,
                'notes' => $movement->notes,
            ];
        });

        return response()->json([
            'success' => true,
            'movements' => $formattedMovements,
        ]);
    }
}
