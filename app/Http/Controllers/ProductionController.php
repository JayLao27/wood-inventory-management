<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\Material;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function index()
    {
        // Get work orders with relationships
        $workOrders = WorkOrder::with(['salesOrder.customer', 'product'])
            ->orderBy('due_date', 'asc')
            ->get();

        // Calculate status counts
        $statusCounts = [
            'pending' => WorkOrder::where('status', 'pending')->count(),
            'in_progress' => WorkOrder::where('status', 'in_progress')->count(),
            'quality_check' => WorkOrder::where('status', 'quality_check')->count(),
            'completed' => WorkOrder::where('status', 'completed')->count(),
            'overdue' => WorkOrder::whereDate('due_date', '<', now())
                ->whereNotIn('status', ['completed'])->count()
        ];

        // Get pending sales orders that need work orders
        $pendingSalesOrders = SalesOrder::with(['items.product', 'customer'])
            ->whereIn('status', ['Pending', 'In production', 'Confirmed'])
            ->get();

        return view('Systems.production', compact('workOrders', 'statusCounts', 'pendingSalesOrders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sales_order_id' => 'required|exists:sales_orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'assigned_to' => 'required|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Generate unique order number
            $orderNumber = 'WO-' . date('Ymd') . '-' . str_pad(WorkOrder::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create work order
            $workOrder = WorkOrder::create([
                'order_number' => $orderNumber,
                'sales_order_id' => $validated['sales_order_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'completion_quantity' => 0,
                'status' => 'pending',
                'due_date' => $validated['due_date'],
                'assigned_to' => $validated['assigned_to'],
                'priority' => $validated['priority'],
                'notes' => $validated['notes'],
            ]);

            // Reserve materials from inventory when work order is created
            $this->reserveMaterials($workOrder);

            // Update sales order status
            $salesOrder = SalesOrder::find($validated['sales_order_id']);
            if ($salesOrder && $salesOrder->status === 'Pending') {
                $salesOrder->update(['status' => 'In production']);
            }

            DB::commit();

            return redirect()->route('production')->with('success', 'Work order created successfully and materials reserved!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create work order: ' . $e->getMessage());
        }
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,quality_check,completed,overdue',
            'completion_quantity' => 'required|integer|min:0',
            'assigned_to' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $workOrder->status;
            $workOrder->update($validated);

            // If status changed to in_progress, deduct materials from inventory
            if ($oldStatus !== 'in_progress' && $validated['status'] === 'in_progress') {
                $this->deductMaterials($workOrder);
            }

            // If completed, update the sales order status
            if ($validated['status'] === 'completed' && $workOrder->completion_quantity >= $workOrder->quantity) {
                $salesOrder = $workOrder->salesOrder;
                if ($salesOrder) {
                    $salesOrder->update(['status' => 'Ready']);
                }
            }

            DB::commit();

            return redirect()->route('production')->with('success', 'Work order updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update work order: ' . $e->getMessage());
        }
    }

    public function start(WorkOrder $workOrder)
    {
        try {
            DB::beginTransaction();

            $workOrder->update(['status' => 'in_progress']);
            
            // Deduct materials when starting production
            $this->deductMaterials($workOrder);

            DB::commit();

            return redirect()->route('production')->with('success', 'Work order started and materials deducted!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to start work order: ' . $e->getMessage());
        }
    }

    public function complete(WorkOrder $workOrder)
    {
        try {
            DB::beginTransaction();

            $workOrder->update([
                'status' => 'completed',
                'completion_quantity' => $workOrder->quantity,
            ]);

            // Update sales order status to Ready for delivery
            if ($workOrder->salesOrder) {
                $workOrder->salesOrder->update(['status' => 'Ready']);
            }

            DB::commit();

            return redirect()->route('production')->with('success', 'Work order completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to complete work order: ' . $e->getMessage());
        }
    }

    /**
     * Reserve materials from inventory for the work order
     */
    private function reserveMaterials(WorkOrder $workOrder)
    {
        $product = $workOrder->product;
        
        // Get materials needed for this product
        $materialsNeeded = $this->getProductMaterials($product, $workOrder->quantity);

        foreach ($materialsNeeded as $materialData) {
            $material = Material::find($materialData['material_id']);
            
            if (!$material || $material->current_stock < $materialData['quantity']) {
                throw new \Exception("Insufficient stock for material: {$material->name}");
            }

            // Create inventory movement record for reservation
            InventoryMovement::create([
                'item_type' => 'material',
                'item_id' => $material->id,
                'movement_type' => 'reserved',
                'quantity' => $materialData['quantity'],
                'reference_type' => 'work_order',
                'reference_id' => $workOrder->id,
                'notes' => "Reserved for Work Order: {$workOrder->order_number}",
            ]);
        }
    }

    /**
     * Deduct materials from inventory when production starts
     */
    private function deductMaterials(WorkOrder $workOrder)
    {
        $product = $workOrder->product;
        $materialsNeeded = $this->getProductMaterials($product, $workOrder->quantity);

        foreach ($materialsNeeded as $materialData) {
            $material = Material::find($materialData['material_id']);
            
            if (!$material || $material->current_stock < $materialData['quantity']) {
                throw new \Exception("Insufficient stock for material: {$material->name}");
            }

            // Deduct from inventory
            $material->decrement('current_stock', $materialData['quantity']);

            // Create inventory movement record
            InventoryMovement::create([
                'item_type' => 'material',
                'item_id' => $material->id,
                'movement_type' => 'out',
                'quantity' => $materialData['quantity'],
                'reference_type' => 'work_order',
                'reference_id' => $workOrder->id,
                'notes' => "Used in production - Work Order: {$workOrder->order_number}",
            ]);
        }
    }

    /**
     * Get materials needed for a product
     * This is a placeholder - implement based on your product-material relationships
     */
    private function getProductMaterials(Product $product, int $quantity)
    {
        // TODO: Implement Bill of Materials (BOM) relationship
        // For now, returning empty array - you'll need to create a product_materials table
        // that defines which materials and how much is needed for each product
        
        // Example structure:
        // return [
        //     ['material_id' => 1, 'quantity' => 5 * $quantity], // 5 units per product
        //     ['material_id' => 2, 'quantity' => 2 * $quantity], // 2 units per product
        // ];
        
        return [];
    }
}
