<?php

namespace Database\Seeders;

use App\Models\InventoryMovement;
use Illuminate\Database\Seeder;

class InventoryMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Material inbound movements from purchase orders
        InventoryMovement::create([
            'item_type' => 'Material',
            'item_id' => 1,
            'movement_type' => 'inbound',
            'quantity' => 500,
            'reference_type' => 'PurchaseOrder',
            'reference_id' => 1,
            'notes' => 'Received oak lumber from Premium Oak Suppliers',
            'status' => 'completed',
        ]);

        InventoryMovement::create([
            'item_type' => 'Material',
            'item_id' => 2,
            'movement_type' => 'inbound',
            'quantity' => 75,
            'reference_type' => 'PurchaseOrder',
            'reference_id' => 2,
            'notes' => 'Partial delivery of maple plywood',
            'status' => 'completed',
        ]);

        InventoryMovement::create([
            'item_type' => 'Material',
            'item_id' => 4,
            'movement_type' => 'inbound',
            'quantity' => 200,
            'reference_type' => 'PurchaseOrder',
            'reference_id' => 4,
            'notes' => 'Pine lumber delivery received',
            'status' => 'completed',
        ]);

        // Product outbound movements from sales orders
        InventoryMovement::create([
            'item_type' => 'Product',
            'item_id' => 1,
            'movement_type' => 'outbound',
            'quantity' => 2,
            'reference_type' => 'SalesOrder',
            'reference_id' => 1,
            'notes' => 'Sold to ABC Furniture Co.',
            'status' => 'completed',
        ]);

        InventoryMovement::create([
            'item_type' => 'Product',
            'item_id' => 2,
            'movement_type' => 'outbound',
            'quantity' => 3,
            'reference_type' => 'SalesOrder',
            'reference_id' => 2,
            'notes' => 'Maple cabinets delivered to XYZ Interior Design',
            'status' => 'completed',
        ]);

        InventoryMovement::create([
            'item_type' => 'Product',
            'item_id' => 3,
            'movement_type' => 'outbound',
            'quantity' => 6,
            'reference_type' => 'SalesOrder',
            'reference_id' => 1,
            'notes' => 'Walnut coffee tables - bulk order',
            'status' => 'completed',
        ]);

        InventoryMovement::create([
            'item_type' => 'Product',
            'item_id' => 4,
            'movement_type' => 'outbound',
            'quantity' => 3,
            'reference_type' => 'SalesOrder',
            'reference_id' => 3,
            'notes' => 'Pine bookshelves to Local Woodcraft Store',
            'status' => 'completed',
        ]);

        InventoryMovement::create([
            'item_type' => 'Product',
            'item_id' => 5,
            'movement_type' => 'outbound',
            'quantity' => 6,
            'reference_type' => 'SalesOrder',
            'reference_id' => 4,
            'notes' => 'Cherry wood doors for housing development',
            'status' => 'pending',
        ]);

        // Material adjustment movements
        InventoryMovement::create([
            'item_type' => 'Material',
            'item_id' => 3,
            'movement_type' => 'adjustment',
            'quantity' => 10,
            'reference_type' => 'InventoryAdjustment',
            'reference_id' => 1,
            'notes' => 'Inventory count adjustment - shrinkage',
            'status' => 'completed',
        ]);

        InventoryMovement::create([
            'item_type' => 'Product',
            'item_id' => 2,
            'movement_type' => 'adjustment',
            'quantity' => 2,
            'reference_type' => 'InventoryAdjustment',
            'reference_id' => 2,
            'notes' => 'Damaged units removed from stock',
            'status' => 'completed',
        ]);

        // Internal transfer
        InventoryMovement::create([
            'item_type' => 'Material',
            'item_id' => 6,
            'movement_type' => 'internal_transfer',
            'quantity' => 5,
            'reference_type' => 'InternalTransfer',
            'reference_id' => 1,
            'notes' => 'Transferred stain from warehouse A to warehouse B',
            'status' => 'completed',
        ]);
    }
}
