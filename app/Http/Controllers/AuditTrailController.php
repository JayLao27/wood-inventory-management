<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\InventoryMovement;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        $limit = 100; // Increased limit for better filtering
        $selectedRole = $request->input('role');

        $inventory = InventoryMovement::with(['user', 'item'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Inventory',
                    'action' => $item->movement_type === 'in' ? 'Stock In' : 'Stock Out',
                    'description' => ($item->item->name ?? 'Unknown Item') . ' (' . $item->quantity . ') - ' . $item->notes,
                    'user' => $item->user->name ?? 'System',
                    'user_role' => $item->user->role ?? 'system',
                    'date' => $item->created_at,
                    'status' => $item->status,
                    'color' => $item->movement_type === 'in' ? 'emerald' : 'orange'
                ];
            });

        $sales = SalesOrder::with(['user', 'customer'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Sales',
                    'action' => 'Order ' . $item->status,
                    'description' => 'Order #' . $item->order_number . ' for ' . ($item->customer->name ?? 'Unknown Customer'),
                    'user' => $item->user->name ?? 'System',
                    'user_role' => $item->user->role ?? 'system',
                    'date' => $item->updated_at,
                    'status' => $item->status,
                    'color' => 'indigo'
                ];
            });

        $accounting = Accounting::with(['user', 'salesOrder', 'purchaseOrder'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Accounting',
                    'action' => $item->transaction_type === 'Income' ? 'Payment Received' : 'Payment Made',
                    'description' => 'Amount: P' . number_format($item->amount, 2) . ' - ' . $item->description,
                    'user' => $item->user->name ?? 'System',
                    'user_role' => $item->user->role ?? 'system',
                    'date' => $item->created_at,
                    'status' => 'Completed',
                    'color' => $item->transaction_type === 'Income' ? 'emerald' : 'red'
                ];
            });

        $production = WorkOrder::with(['user', 'product'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Production',
                    'action' => 'Work Order ' . str_replace('_', ' ', $item->status),
                    'description' => 'WO #' . $item->order_number . ' for ' . ($item->product->product_name ?? 'Unknown Product'),
                    'user' => $item->user->name ?? 'System',
                    'user_role' => $item->user->role ?? 'system',
                    'date' => $item->updated_at,
                    'status' => $item->status,
                    'color' => 'purple'
                ];
            });

        $procurement = PurchaseOrder::with(['user', 'supplier'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Procurement',
                    'action' => 'Purchase Order ' . $item->status,
                    'description' => 'PO #' . $item->order_number . ' from ' . ($item->supplier->name ?? 'Unknown Supplier'),
                    'user' => $item->user->name ?? 'System',
                    'user_role' => $item->user->role ?? 'system',
                    'date' => $item->updated_at,
                    'status' => $item->status,
                    'color' => 'blue'
                ];
            });

        // Combine and sort by date desc
        $allActivities = $inventory->concat($sales)
            ->concat($accounting)
            ->concat($production)
            ->concat($procurement)
            ->sortByDesc('date');

        // Get unique roles for filtering (excluding admin)
        $availableRoles = \App\Models\User::where('role', '!=', 'admin')
            ->distinct()
            ->pluck('role')
            ->toArray();

        // Apply filtering if role is selected
        if ($selectedRole) {
            $activities = $allActivities->filter(function ($activity) use ($selectedRole) {
                return $activity['user_role'] === $selectedRole;
            })->values();
        } else {
            $activities = $allActivities->values();
        }

        return view('Systems.audit-trails', compact('activities', 'availableRoles', 'selectedRole'));
    }
}
