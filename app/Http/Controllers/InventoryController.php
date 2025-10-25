<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('inventoryMovements')->orderBy('product_name')->get();
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
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'production_cost' => 'nullable|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id'
        ]);

        if ($request->type === 'product') {
            $item = Product::create([
                'product_name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'unit' => $request->unit,
                'current_stock' => $request->current_stock,
                'minimum_stock' => $request->minimum_stock,
                'selling_price' => $request->selling_price ?? 0,
                'production_cost' => $request->production_cost ?? 0,
                'status' => 'active'
            ]);
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

        // Create initial inventory movement
        InventoryMovement::create([
            'item_type' => $request->type,
            'item_id' => $item->id,
            'movement_type' => 'in',
            'quantity' => $request->current_stock,
            'reference_type' => 'initial_stock',
            'notes' => 'Initial stock entry'
        ]);

        return redirect()->route('inventory')->with('success', 'Item added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:product,material',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'production_cost' => 'nullable|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id'
        ]);

        if ($request->type === 'product') {
            $item = Product::findOrFail($id);
            $item->update([
                'product_name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'unit' => $request->unit,
                'current_stock' => $request->current_stock,
                'minimum_stock' => $request->minimum_stock,
                'selling_price' => $request->selling_price ?? 0,
                'production_cost' => $request->production_cost ?? 0
            ]);
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

        return redirect()->route('inventory')->with('success', 'Item updated successfully!');
    }

    public function destroy($id, $type)
    {
        if ($type === 'product') {
            $item = Product::findOrFail($id);
        } else {
            $item = Material::findOrFail($id);
        }

        $item->delete();

        return redirect()->route('inventory')->with('success', 'Item deleted successfully!');
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
}
