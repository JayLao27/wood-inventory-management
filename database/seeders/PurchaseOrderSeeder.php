<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Purchase Order 1 - Premium Oak Suppliers
        $po1 = PurchaseOrder::create([
            'order_number' => 'PO-2025-001',
            'supplier_id' => 1,
            'order_date' => now()->subDays(20),
            'expected_delivery' => now()->subDays(5),
            'total_amount' => 3500.00,
            'paid_amount' => 3500.00,
            'notes' => 'Oak lumber delivery received',
            'status' => 'received',
            'assigned_to' => 'John',
            'quality_status' => 'approved',
            'approved_by' => 'Manager',
            'approval_date' => now()->subDays(18),
            'updated_date' => now()->subDays(5),
        ]);

        PurchaseOrderItem::create([
            'purchase_order_id' => $po1->id,
            'material_id' => 1,
            'quantity' => 500,
            'unit_price' => 5.50,
            'total_price' => 2750.00,
        ]);

        PurchaseOrderItem::create([
            'purchase_order_id' => $po1->id,
            'material_id' => 6,
            'quantity' => 2,
            'unit_price' => 22.50,
            'total_price' => 45.00,
        ]);

        // Purchase Order 2 - Maple Lumber Co.
        $po2 = PurchaseOrder::create([
            'order_number' => 'PO-2025-002',
            'supplier_id' => 2,
            'order_date' => now()->subDays(15),
            'expected_delivery' => now()->addDays(5),
            'total_amount' => 7200.00,
            'paid_amount' => 3600.00,
            'notes' => 'Maple plywood order',
            'status' => 'approved',
            'assigned_to' => 'Sarah',
            'quality_status' => 'pending',
            'approved_by' => 'Manager',
            'approval_date' => now()->subDays(14),
            'updated_date' => now()->subDays(2),
        ]);

        PurchaseOrderItem::create([
            'purchase_order_id' => $po2->id,
            'material_id' => 2,
            'quantity' => 150,
            'unit_price' => 45.00,
            'total_price' => 6750.00,
        ]);

        // Purchase Order 3 - Exotic Woods Trading
        $po3 = PurchaseOrder::create([
            'order_number' => 'PO-2025-003',
            'supplier_id' => 3,
            'order_date' => now()->subDays(10),
            'expected_delivery' => now()->addDays(8),
            'total_amount' => 2625.00,
            'paid_amount' => 0,
            'notes' => 'Walnut veneer shipment',
            'status' => 'pending',
            'assigned_to' => 'Carlos',
            'quality_status' => 'pending',
            'approved_by' => null,
            'approval_date' => null,
            'updated_date' => now(),
        ]);

        PurchaseOrderItem::create([
            'purchase_order_id' => $po3->id,
            'material_id' => 3,
            'quantity' => 300,
            'unit_price' => 8.75,
            'total_price' => 2625.00,
        ]);

        // Purchase Order 4 - Cedar & Pine Mills
        $po4 = PurchaseOrder::create([
            'order_number' => 'PO-2025-004',
            'supplier_id' => 4,
            'order_date' => now()->subDays(8),
            'expected_delivery' => now()->addDays(3),
            'total_amount' => 4000.00,
            'paid_amount' => 2000.00,
            'notes' => 'Pine lumber and cedar shingles',
            'status' => 'approved',
            'assigned_to' => 'Emma',
            'quality_status' => 'pending',
            'approved_by' => 'Manager',
            'approval_date' => now()->subDays(7),
            'updated_date' => now()->subDays(1),
        ]);

        PurchaseOrderItem::create([
            'purchase_order_id' => $po4->id,
            'material_id' => 4,
            'quantity' => 200,
            'unit_price' => 12.00,
            'total_price' => 2400.00,
        ]);

        PurchaseOrderItem::create([
            'purchase_order_id' => $po4->id,
            'material_id' => 5,
            'quantity' => 50,
            'unit_price' => 35.00,
            'total_price' => 1750.00,
        ]);
    }
}
