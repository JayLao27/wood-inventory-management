<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Add database indexes for optimal query performance
     */
    public function up(): void
    {
        // Customers table indexes
        if (Schema::hasTable('customers')) {
            Schema::table('customers', function (Blueprint $table) {
                // Index frequently searched fields
                $table->index('email');
                $table->index('phone');
                $table->index('customer_type');
                $table->index('created_at');
            });
        }

        // Users table indexes
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index('email');
                $table->index('role');
                $table->index('created_at');
            });
        }

        // Sales Orders table indexes
        if (Schema::hasTable('sales_orders')) {
            Schema::table('sales_orders', function (Blueprint $table) {
                // Foreign key and status are frequently filtered
                $table->index('customer_id');
                $table->index('status');
                $table->index('payment_status');
                $table->index('order_date');
                $table->index('created_at');
                // Composite index for common queries
                $table->index(['customer_id', 'status']);
                $table->index(['status', 'created_at']);
            });
        }

        // Sales Order Items table indexes
        if (Schema::hasTable('sales_order_items')) {
            Schema::table('sales_order_items', function (Blueprint $table) {
                $table->index('sales_order_id');
                $table->index('product_id');
                // Composite for retrieving items by order
                $table->index(['sales_order_id', 'created_at']);
            });
        }

        // Products table indexes
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->index('created_at');
                $table->index('updated_at');
            });
        }

        // Materials table indexes
        if (Schema::hasTable('materials')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->index('created_at');
            });
        }

        // Suppliers table indexes
        if (Schema::hasTable('suppliers')) {
            Schema::table('suppliers', function (Blueprint $table) {
                $table->index('created_at');
            });
        }

        // Purchase Orders table indexes
        if (Schema::hasTable('purchase_orders')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->index('supplier_id');
                $table->index('status');
                $table->index('order_date');
                $table->index('created_at');
                // Composite indexes for common queries
                $table->index(['supplier_id', 'status']);
                $table->index(['status', 'created_at']);
            });
        }

        // Purchase Order Items table indexes
        if (Schema::hasTable('purchase_order_items')) {
            Schema::table('purchase_order_items', function (Blueprint $table) {
                $table->index('purchase_order_id');
                $table->index('material_id');
                $table->index(['purchase_order_id', 'created_at']);
            });
        }

        // Work Orders table indexes
        if (Schema::hasTable('work_orders')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->index('sales_order_id');
                $table->index('product_id');
                $table->index('status');
                $table->index('priority');
                $table->index('assigned_to');
                $table->index('due_date');
                $table->index('created_at');
                // Composite indexes for common queries
                $table->index(['status', 'assigned_to']);
                $table->index(['status', 'due_date']);
                $table->index(['assigned_to', 'status']);
            });
        }

        // Inventory Movements table indexes
        if (Schema::hasTable('inventory_movements')) {
            Schema::table('inventory_movements', function (Blueprint $table) {
                $table->index('reference_type');
                $table->index('reference_id');
                $table->index('created_at');
                // Composite for tracking movements by reference
                $table->index(['reference_type', 'reference_id']);
                $table->index(['reference_type', 'created_at']);
            });
        }

        // Accounting table indexes
        if (Schema::hasTable('accounting')) {
            Schema::table('accounting', function (Blueprint $table) {
                $table->index('reference_type');
                $table->index('reference_id');
                $table->index('transaction_type');
                $table->index('created_at');
                // Composite for financial reporting
                $table->index(['transaction_type', 'created_at']);
            });
        }

        // Product Materials table indexes (if pivot table exists)
        if (Schema::hasTable('product_materials')) {
            Schema::table('product_materials', function (Blueprint $table) {
                $table->index('product_id');
                $table->index('material_id');
                $table->index(['product_id', 'material_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop all indexes created
        $tables = [
            'customers', 'users', 'sales_orders', 'sales_order_items', 
            'products', 'materials', 'suppliers', 'purchase_orders', 
            'purchase_order_items', 'work_orders', 'inventory_movements', 
            'accounting', 'product_materials'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    // Drop all indexes except primary
                    $table->dropAllIndexes();
                });
            }
        }
    }
};
