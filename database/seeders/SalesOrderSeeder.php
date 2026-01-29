<?php

namespace Database\Seeders;

use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Illuminate\Database\Seeder;

class SalesOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sales Order 1 - ABC Furniture Co.
        $order1 = SalesOrder::create([
            'order_number' => 'SO-2025-001',
            'customer_id' => 1,
            'order_date' => now()->subDays(15),
            'delivery_date' => now()->addDays(5),
            'total_amount' => 2400.00,
            'paid_amount' => 1200.00,
            'payment_status' => 'partial',
            'note' => 'Bulk order for showroom',
        ]);

        SalesOrderItem::create([
            'sales_order_id' => $order1->id,
            'product_id' => 1,
            'quantity' => 2,
            'unit_price' => 750.00,
            'subtotal' => 1500.00,
            'total_price' => 1500.00,
        ]);

        SalesOrderItem::create([
            'sales_order_id' => $order1->id,
            'product_id' => 3,
            'quantity' => 4,
            'unit_price' => 350.00,
            'subtotal' => 1400.00,
            'total_price' => 1400.00,
        ]);

        // Sales Order 2 - XYZ Interior Design
        $order2 = SalesOrder::create([
            'order_number' => 'SO-2025-002',
            'customer_id' => 2,
            'order_date' => now()->subDays(10),
            'delivery_date' => now()->addDays(10),
            'total_amount' => 1500.00,
            'paid_amount' => 1500.00,
            'payment_status' => 'paid',
            'note' => 'Custom interior project',
        ]);

        SalesOrderItem::create([
            'sales_order_id' => $order2->id,
            'product_id' => 2,
            'quantity' => 3,
            'unit_price' => 450.00,
            'subtotal' => 1350.00,
            'total_price' => 1350.00,
        ]);

        SalesOrderItem::create([
            'sales_order_id' => $order2->id,
            'product_id' => 5,
            'quantity' => 1,
            'unit_price' => 420.00,
            'subtotal' => 420.00,
            'total_price' => 420.00,
        ]);

        // Sales Order 3 - Local Woodcraft Store
        $order3 = SalesOrder::create([
            'order_number' => 'SO-2025-003',
            'customer_id' => 3,
            'order_date' => now()->subDays(5),
            'delivery_date' => now()->addDays(2),
            'total_amount' => 980.00,
            'paid_amount' => 0,
            'payment_status' => 'pending',
            'note' => 'Regular inventory replenishment',
        ]);

        SalesOrderItem::create([
            'sales_order_id' => $order3->id,
            'product_id' => 4,
            'quantity' => 3,
            'unit_price' => 280.00,
            'subtotal' => 840.00,
            'total_price' => 840.00,
        ]);

        SalesOrderItem::create([
            'sales_order_id' => $order3->id,
            'product_id' => 3,
            'quantity' => 2,
            'unit_price' => 350.00,
            'subtotal' => 700.00,
            'total_price' => 700.00,
        ]);

        // Sales Order 4 - Premium Home Builders
        $order4 = SalesOrder::create([
            'order_number' => 'SO-2025-004',
            'customer_id' => 4,
            'order_date' => now()->subDays(3),
            'delivery_date' => now()->addDays(7),
            'total_amount' => 3200.00,
            'paid_amount' => 1600.00,
            'payment_status' => 'partial',
            'note' => 'New housing development',
        ]);

        SalesOrderItem::create([
            'sales_order_id' => $order4->id,
            'product_id' => 5,
            'quantity' => 5,
            'unit_price' => 420.00,
            'subtotal' => 2100.00,
            'total_price' => 2100.00,
        ]);

        SalesOrderItem::create([
            'sales_order_id' => $order4->id,
            'product_id' => 1,
            'quantity' => 1,
            'unit_price' => 750.00,
            'subtotal' => 750.00,
            'total_price' => 750.00,
        ]);
    }
}
