<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->string('item_type'); // 'material' or 'product'
            $table->unsignedBigInteger('item_id');
            $table->string('movement_type'); // 'in', 'out', 'adjustment'
            $table->decimal('quantity', 12, 2);
            $table->string('reference_type')->nullable(); // 'purchase_order', 'sales_order', 'work_order', 'adjustment'
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};