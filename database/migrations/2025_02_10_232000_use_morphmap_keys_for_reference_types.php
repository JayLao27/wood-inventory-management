<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('inventory_movements')
            ->where('reference_type', 'App\Models\PurchaseOrder')
            ->update(['reference_type' => 'purchase_order']);
            
        DB::table('inventory_movements')
            ->where('reference_type', 'App\Models\WorkOrder')
            ->update(['reference_type' => 'work_order']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not meant to be reverted
    }
};
