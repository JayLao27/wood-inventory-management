<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_name')->after('id');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->decimal('production_cost', 12, 2)->default(0);
            $table->decimal('selling_price', 12, 2)->default(0);
            $table->decimal('current_stock', 12, 2)->default(0);
            $table->decimal('minimum_stock', 12, 2)->default(0);
            $table->string('unit')->default('pieces');
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            // Rename existing columns for consistency
            $table->renameColumn('name', 'old_name');
            $table->renameColumn('unit_price', 'old_unit_price');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'product_name', 'description', 'category', 'production_cost', 
                'selling_price', 'current_stock', 'minimum_stock', 'unit', 'status'
            ]);
            $table->renameColumn('old_name', 'name');
            $table->renameColumn('old_unit_price', 'unit_price');
        });
    }
};