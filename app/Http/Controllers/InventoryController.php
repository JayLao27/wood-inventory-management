<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Material;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with(['inventoryMovements', 'materials'])->orderBy('product_name')->get();
        $materials = Material::with(['supplier', 'inventoryMovements'])->orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        
        // Calculate metrics
        $totalItems = $products->count() + $materials->count();
        $lowStockAlerts = $products->where('current_stock', '<=', 'minimum_stock')->count() + 
                         $materials->where('current_stock', '<=', 'minimum_stock')->count(); 
        $totalValue = $materials->sum(function($material) {
            return $material->current_stock * $material->unit_cost;
        });
        $newOrders = $products->where('status', 'active')->count();
        $pendingDeliveries = 0; // This would come from purchase orders
        
        return view('Systems.inventory', compact(
            'products', 'materials', 'suppliers', 'totalItems', 
            'lowStockAlerts', 'totalValue', 'newOrders', 'pendingDeliveries'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:product,material',
            'name' => 'required_if:type,material|string|max:255',
            'product_name' => 'required_if:type,product|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required_if:type,material|numeric|min:0',
            'minimum_stock' => 'required_if:type,material|numeric|min:0',
            'unit_cost' => 'required_if:type,material|numeric|min:0',
            'supplier_id' => 'required_if:type,material|exists:suppliers,id',
            'selling_price' => 'required_if:type,product|numeric|min:0',
            'production_cost' => 'required_if:type,product|numeric|min:0',
            'materials' => 'nullable|array',
            'materials.*.material_id' => 'required_with:materials|exists:materials,id',
            'materials.*.quantity_needed' => 'required_with:materials|numeric|min:0.01'
        ]);

        if ($request->type === 'product') {
            $item = Product::create([
                'product_name' => $request->product_name,
                'category' => $request->category,
                'unit' => $request->unit,
                'current_stock' => 0,
                'minimum_stock' => 0,
                'selling_price' => $request->selling_price,
                'production_cost' => $request->production_cost,
            ]);

            // Attach materials to product if provided
            if ($request->has('materials') && is_array($request->materials)) {
                foreach ($request->materials as $material) {
                    $item->materials()->attach($material['material_id'], [
                        'quantity_needed' => $material['quantity_needed']
                    ]);
                }
            }
        } else {
            $item = Material::create([
                'name' => $request->name,
                'category' => $request->category,
                'unit' => $request->unit,
                'current_stock' => $request->current_stock,
                'minimum_stock' => $request->minimum_stock,
                'unit_cost' => $request->unit_cost,
                'supplier_id' => $request->supplier_id
            ]);
        }

        // Create initial inventory movement only for materials
        if ($request->type === 'material') {
            InventoryMovement::create([
                'item_type' => $request->type,
                'item_id' => $item->id,
                'movement_type' => 'in',
                'quantity' => $request->current_stock,
                'reference_type' => 'initial_stock',
                'notes' => 'Initial stock entry'
            ]);
        }

        $itemType = $request->type === 'product' ? 'Product' : 'Material';
        return redirect()->route('inventory')->with('success', $itemType . ' added successfully!');
    }

    public function editProduct($id)
    {
        $product = Product::with('materials')->findOrFail($id);
        
        return response()->json([
            'product_name' => $product->product_name,
            'description' => $product->description,
            'category' => $product->category,
            'unit' => $product->unit,
            'production_cost' => $product->production_cost,
            'selling_price' => $product->selling_price,
            'materials' => $product->materials->map(function($material) {
                return [
                    'id' => $material->id,
                    'name' => $material->name,
                    'unit' => $material->unit,
                    'pivot' => [
                        'quantity_needed' => $material->pivot->quantity_needed
                    ]
                ];
            })
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:product,material',
            'name' => 'required_if:type,material|string|max:255',
            'product_name' => 'required_if:type,product|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required_if:type,material|numeric|min:0',
            'minimum_stock' => 'required_if:type,material|numeric|min:0',
            'unit_cost' => 'required_if:type,material|numeric|min:0',
            'supplier_id' => 'required_if:type,material|exists:suppliers,id',
            'selling_price' => 'required_if:type,product|numeric|min:0',
            'production_cost' => 'required_if:type,product|numeric|min:0',
            'materials' => 'nullable|array',
            'materials.*.material_id' => 'required_with:materials|exists:materials,id',
            'materials.*.quantity_needed' => 'required_with:materials|numeric|min:0.01'
        ]);

        if ($request->type === 'product') {
            $item = Product::findOrFail($id);
            $item->update([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'category' => $request->category,
                'unit' => $request->unit,
                'selling_price' => $request->selling_price,
                'production_cost' => $request->production_cost
            ]);

            // Update materials
            if ($request->has('materials') && is_array($request->materials)) {
                // Detach all existing materials
                $item->materials()->detach();
                
                // Attach new materials
                foreach ($request->materials as $material) {
                    $item->materials()->attach($material['material_id'], [
                        'quantity_needed' => $material['quantity_needed']
                    ]);
                }
            } else {
                // If no materials provided, detach all
                $item->materials()->detach();
            }
        } else {
            $item = Material::findOrFail($id);
            $item->update([
                'name' => $request->name,
                'category' => $request->category,
                'unit' => $request->unit,
                'current_stock' => $request->current_stock,
                'minimum_stock' => $request->minimum_stock,
                'unit_cost' => $request->unit_cost,
                'supplier_id' => $request->supplier_id
            ]);
        }

        $itemType = $request->type === 'product' ? 'Product' : 'Material';
        return redirect()->route('inventory')->with('success', $itemType . ' updated successfully!');
    }

    public function destroy($id, $type)
    {
        if ($type === 'product') {
            $item = Product::findOrFail($id);
        } else {
            $item = Material::findOrFail($id);
        }

        $item->delete();

        $itemType = $type === 'product' ? 'Product' : 'Material';
        return redirect()->route('inventory')->with('success', $itemType . ' deleted successfully!');
    }

    public function getDetails(Request $request, $id)
    {
        $type = $request->query('type');
        
        if ($type === 'product') {
            $item = Product::with('inventoryMovements')->findOrFail($id);
            $cost = $item->production_cost; // For products, show production cost
        } else {
            $item = Material::with('inventoryMovements')->findOrFail($id);
            $cost = $item->unit_cost; // For materials, show unit cost
        }

        $movements = $item->inventoryMovements
            ->sortByDesc('created_at')
            ->map(function($movement) {
                return [
                    'movement_type' => $movement->movement_type,
                    'quantity' => $movement->quantity,
                    'reference_type' => $movement->reference_type,
                    'reference_id' => $movement->reference_id,
                    'notes' => $movement->notes,
                    'created_at' => $movement->created_at,
                ];
            })
            ->values();

        return response()->json([
            'item' => [
                'name' => $item->name ?? $item->product_name,
                'current_stock' => $item->current_stock,
                'minimum_stock' => $item->minimum_stock ?? 0,
                'unit_cost' => $cost ?? 0,
                'unit' => $item->unit,
            ],
            'movements' => $movements
        ]);
    }

    public function adjustStock(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:product,material',
            'movement_type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($request->type === 'product') {
            $item = Product::findOrFail($id);
        } else {
            $item = Material::findOrFail($id);
        }

        DB::transaction(function () use ($item, $request) {
            // Create inventory movement
            InventoryMovement::create([
                'item_type' => $request->type,
                'item_id' => $item->id,
                'movement_type' => $request->movement_type,
                'quantity' => $request->quantity,
                'reference_type' => 'manual_adjustment',
                'notes' => $request->notes
            ]);

            // Update stock
            if ($request->movement_type === 'in') {
                $item->increment('current_stock', $request->quantity);
            } elseif ($request->movement_type === 'out') {
                $item->decrement('current_stock', $request->quantity);
            } else {
                $item->update(['current_stock' => $request->quantity]);
            }
        });

        return redirect()->route('inventory')->with('success', 'Stock adjusted successfully!');
    }

    /**
     * Get stock movements report - logs of all stock movements
     */
    public function stockMovementsReport(Request $request)
    {
        $query = InventoryMovement::query()
            ->with('item')
            ->orderBy('created_at', 'desc');

        // Apply filters if provided
        if ($request->has('movement_type') && $request->movement_type) {
            $query->where('movement_type', $request->movement_type);
        }

        if ($request->has('item_type') && $request->item_type) {
            $query->where('item_type', $request->item_type);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->get();

        // Format for response
        $formattedMovements = $movements->map(function ($movement) {
            $itemName = '';
            $itemUnit = '';
            
            if ($movement->item_type === 'material') {
                $itemName = $movement->item?->name ?? 'Unknown Material';
                $itemUnit = $movement->item?->unit ?? 'unit';
            } else {
                $itemName = $movement->item?->product_name ?? 'Unknown Product';
                $itemUnit = $movement->item?->unit ?? 'unit';
            }

            // Determine movement label
            $movementLabel = match($movement->movement_type) {
                'in' => '📦 Stock In',
                'out' => '📤 Stock Out',
                'adjustment' => '⚙️ Adjustment',
                default => $movement->movement_type
            };

            // Get reference info
            $referenceInfo = '';
            if ($movement->reference_type === 'purchase_order') {
                $po = PurchaseOrder::find($movement->reference_id);
                $referenceInfo = $po ? "PO: {$po->order_number}" : "PO #" . $movement->reference_id;
            } elseif ($movement->reference_type === 'work_order') {
                $referenceInfo = "Work Order #" . $movement->reference_id;
            } elseif ($movement->reference_type === 'manual_adjustment') {
                $referenceInfo = "Manual Adjustment";
            } elseif ($movement->reference_type === 'initial_stock') {
                $referenceInfo = "Initial Stock";
            } else {
                $referenceInfo = ucfirst(str_replace('_', ' ', $movement->reference_type));
            }

            return [
                'id' => $movement->id,
                'date' => $movement->created_at->format('Y-m-d'),
                'time' => $movement->created_at->format('H:i'),
                'movement_type' => $movement->movement_type,
                'movement_label' => $movementLabel,
                'item_type' => $movement->item_type,
                'item_name' => $itemName,
                'unit' => $itemUnit,
                'quantity' => (float) $movement->quantity,
                'reference_type' => $movement->reference_type,
                'reference_info' => $referenceInfo,
                'notes' => $movement->notes,
                'status' => $movement->status ?? 'completed',
                'created_at' => $movement->created_at
            ];
        });

        // Calculate summary
        $totalIn = $movements->where('movement_type', 'in')->sum('quantity');
        $totalOut = $movements->where('movement_type', 'out')->sum('quantity');

        return response()->json([
            'success' => true,
            'movements' => $formattedMovements,
            'summary' => [
                'total_in' => (float) $totalIn,
                'total_out' => (float) $totalOut,
                'total_movements' => count($formattedMovements)
            ]
        ]);
    }
}
