<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Customer;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of sales orders.
     */
    public function index()
    {
        $orders = SalesOrder::with('customer')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($orders);
    }

    /**
     * Store a newly created sales order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'delivery_date' => 'required|date|after_or_equal:today',
            'product' => 'required|string|max:255',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:Pending,In Production,Ready,Delivered,Cancelled',
            'payment_status' => 'nullable|in:Unpaid,Partial,Paid',
            'notes' => 'nullable|string'
        ]);

        $validated['order_date'] = now();
        $validated['status'] = $validated['status'] ?? 'Pending';
        $validated['payment_status'] = $validated['payment_status'] ?? 'Unpaid';
        $validated['total_amount'] = $validated['total_amount'] ?? 0;

        $order = SalesOrder::create($validated);

        // Update customer totals
        $customer = Customer::find($validated['customer_id']);
        $customer->increment('total_orders');
        $customer->increment('total_spent', $validated['total_amount']);

        $order->load('customer');

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'order' => $order
        ], 201);
    }

    /**
     * Display the specified sales order.
     */
    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load('customer');
        return response()->json($salesOrder);
    }

    /**
     * Update the specified sales order.
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        $oldAmount = $salesOrder->total_amount;
        $oldCustomerId = $salesOrder->customer_id;

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'delivery_date' => 'required|date',
            'product' => 'required|string|max:255',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:Pending,In Production,Ready,Delivered,Cancelled',
            'payment_status' => 'nullable|in:Unpaid,Partial,Paid',
            'notes' => 'nullable|string'
        ]);

        $salesOrder->update($validated);

        // Update customer totals if amount or customer changed
        if ($oldCustomerId != $validated['customer_id']) {
            // Decrease old customer
            $oldCustomer = Customer::find($oldCustomerId);
            if ($oldCustomer) {
                $oldCustomer->decrement('total_orders');
                $oldCustomer->decrement('total_spent', $oldAmount);
            }

            // Increase new customer
            $newCustomer = Customer::find($validated['customer_id']);
            if ($newCustomer) {
                $newCustomer->increment('total_orders');
                $newCustomer->increment('total_spent', $validated['total_amount'] ?? 0);
            }
        } elseif ($oldAmount != ($validated['total_amount'] ?? 0)) {
            $customer = Customer::find($validated['customer_id']);
            if ($customer) {
                $difference = ($validated['total_amount'] ?? 0) - $oldAmount;
                if ($difference > 0) {
                    $customer->increment('total_spent', $difference);
                } else {
                    $customer->decrement('total_spent', abs($difference));
                }
            }
        }

        $salesOrder->load('customer');

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'order' => $salesOrder
        ]);
    }

    /**
     * Remove the specified sales order.
     */
    public function destroy(SalesOrder $salesOrder)
    {
        $customer = Customer::find($salesOrder->customer_id);
        if ($customer) {
            $customer->decrement('total_orders');
            $customer->decrement('total_spent', $salesOrder->total_amount);
        }

        $salesOrder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }

    /**
     * Get list of customers for dropdown.
     */
    public function getCustomers()
    {
        $customers = Customer::orderBy('customer_name')->get();
        return response()->json($customers);
    }
}