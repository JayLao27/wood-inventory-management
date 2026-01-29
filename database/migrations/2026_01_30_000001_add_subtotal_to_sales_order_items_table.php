<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales_order_items', function (Blueprint $table) {
            // Add subtotal column as an alias for total_price
            if (!Schema::hasColumn('sales_order_items', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->after('unit_price')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_items', function (Blueprint $table) {
            if (Schema::hasColumn('sales_order_items', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }
};
