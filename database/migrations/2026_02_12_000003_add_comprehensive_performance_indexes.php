<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations - Comprehensive performance indexes
     */
    public function up(): void
    {
        // Get existing indexes per table to avoid duplicates
        $this->addIndexIfNotExists('accounting', 'idx_transaction_type', ['transaction_type']);
        $this->addIndexIfNotExists('accounting', 'idx_date', ['date']);
        $this->addIndexIfNotExists('accounting', 'idx_type_date', ['transaction_type', 'date']);
        $this->addIndexIfNotExists('accounting', 'idx_sales_order_id', ['sales_order_id']);
        $this->addIndexIfNotExists('accounting', 'idx_purchase_order_id', ['purchase_order_id']);

        $this->addIndexIfNotExists('sales_orders', 'idx_status', ['status']);
        $this->addIndexIfNotExists('sales_orders', 'idx_payment_status', ['payment_status']);
        $this->addIndexIfNotExists('sales_orders', 'idx_order_date', ['order_date']);
        $this->addIndexIfNotExists('sales_orders', 'idx_customer_status', ['customer_id', 'status']);
        $this->addIndexIfNotExists('sales_orders', 'idx_status_created', ['status', 'created_at']);

        $this->addIndexIfNotExists('purchase_orders', 'idx_po_status', ['status']);
        $this->addIndexIfNotExists('purchase_orders', 'idx_payment_status', ['payment_status']);
        $this->addIndexIfNotExists('purchase_orders', 'idx_order_date', ['order_date']);
        $this->addIndexIfNotExists('purchase_orders', 'idx_supplier_id', ['supplier_id']);
        $this->addIndexIfNotExists('purchase_orders', 'idx_supplier_status', ['supplier_id', 'status']);
        $this->addIndexIfNotExists('purchase_orders', 'idx_status_created', ['status', 'created_at']);

        $this->addIndexIfNotExists('work_orders', 'idx_wo_status', ['status']);
        $this->addIndexIfNotExists('work_orders', 'idx_due_date', ['due_date']);
        $this->addIndexIfNotExists('work_orders', 'idx_sales_order_id', ['sales_order_id']);
        $this->addIndexIfNotExists('work_orders', 'idx_product_id', ['product_id']);
        $this->addIndexIfNotExists('work_orders', 'idx_priority', ['priority']);
        $this->addIndexIfNotExists('work_orders', 'idx_status_assigned', ['status', 'assigned_to']);
        $this->addIndexIfNotExists('work_orders', 'idx_status_due', ['status', 'due_date']);

        $this->addIndexIfNotExists('inventory_movements', 'idx_item_type_id', ['item_type', 'item_id']);
        $this->addIndexIfNotExists('inventory_movements', 'idx_reference', ['reference_type', 'reference_id']);
        $this->addIndexIfNotExists('inventory_movements', 'idx_movement_type', ['movement_type']);

        $this->addIndexIfNotExists('materials', 'idx_stock_minimum', ['current_stock', 'minimum_stock']);
        $this->addIndexIfNotExists('materials', 'idx_created_at', ['created_at']);

        $this->addIndexIfNotExists('products', 'idx_created_at', ['created_at']);

        $this->addIndexIfNotExists('customers', 'idx_email', ['email']);
        $this->addIndexIfNotExists('customers', 'idx_customer_type', ['customer_type']);
        $this->addIndexIfNotExists('customers', 'idx_customer_created', ['created_at']);

        $this->addIndexIfNotExists('suppliers', 'idx_created_at', ['created_at']);
    }

    /**
     * Add index only if it doesn't already exist
     */
    private function addIndexIfNotExists($table, $indexName, $columns)
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        try {
            $indexes = DB::select("SHOW INDEX FROM `{$table}`");
            $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();

            if (!in_array($indexName, $existingIndexes)) {
                Schema::table($table, function (Blueprint $table) use ($indexName, $columns) {
                    $table->index($columns, $indexName);
                });
            }
        } catch (\Exception $e) {
            // Silently ignore if query fails
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Indexes will be dropped automatically when table is dropped
    }
};
