<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Material;

class ProcurementController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $purchaseOrders = PurchaseOrder::with(['supplier', 'items'])->get();
        $materials = Material::all();
        
        $totalSpent = PurchaseOrder::sum('total_amount');
        $paymentsMade = PurchaseOrder::where('payment_status', 'Paid')->sum('total_amount');
        $pendingPayments = PurchaseOrder::whereIn('payment_status', ['Pending', 'Partial'])->sum('total_amount');
        $activeSuppliers = Supplier::where('status', 'active')->count();
        $lowStockAlerts = Material::whereRaw('current_stock <= minimum_stock')->count();
        
        return view('Systems.procurement', compact(
            'suppliers', 'purchaseOrders', 'materials', 'totalSpent', 
            'paymentsMade', 'pendingPayments', 'activeSuppliers', 'lowStockAlerts'
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

        $purchaseOrder = PurchaseOrder::create([
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
                'line_total' => $lineTotal,
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

    public function destroySupplier($id)
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
}