<?php

namespace Database\Seeders;

use App\Models\Accounting;
use App\Models\SalesOrder;
use App\Models\PurchaseOrder;
use Illuminate\Database\Seeder;

class AccountingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salesOrders = SalesOrder::where('status', '!=', 'Cancelled')->get();
        $purchaseOrders = PurchaseOrder::where('status', '!=', 'cancelled')->get();

        // Income - Sales Orders (30 transactions)
        if ($salesOrders->isNotEmpty()) {
            for ($i = 0; $i < 30; $i++) {
                $order = $salesOrders->random();
                $amount = rand(500, (int)$order->total_amount);
                
                Accounting::create([
                    'transaction_type' => 'Income',
                    'amount' => $amount,
                    'date' => \Carbon\Carbon::parse($order->order_date)->addDays(rand(0, 5)),
                    'description' => 'Payment for Sales Order ' . $order->order_number,
                    'sales_order_id' => $order->id,
                    'purchase_order_id' => null,
                ]);
            }
        }

        // Expense - Purchase Orders (20 transactions)
        if ($purchaseOrders->isNotEmpty()) {
            for ($i = 0; $i < 20; $i++) {
                $po = $purchaseOrders->random();
                $amount = rand(500, (int)$po->total_amount);
                
                Accounting::create([
                    'transaction_type' => 'Expense',
                    'amount' => $amount,
                    'date' => \Carbon\Carbon::parse($po->order_date)->addDays(rand(0, 5)),
                    'description' => 'Payment for Purchase Order ' . $po->order_number,
                    'sales_order_id' => null,
                    'purchase_order_id' => $po->id,
                ]);
            }
        }

        // Additional random expenses (e.g. Utility, Rent)
        $expenseTypes = ['Utility Bill', 'Rent', 'Maintenance', 'Office Supplies'];
        for ($i = 0; $i < 10; $i++) {
            Accounting::create([
                'transaction_type' => 'Expense',
                'amount' => rand(100, 5000),
                'date' => now()->subDays(rand(1, 30)),
                'description' => $expenseTypes[array_rand($expenseTypes)],
                'sales_order_id' => null,
                'purchase_order_id' => null,
            ]);
        }
    }
}
