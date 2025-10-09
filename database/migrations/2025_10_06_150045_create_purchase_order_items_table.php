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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id('purchase_order_items_id');
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('material_id');
            $table->string('reference_id')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('reference_type', 10, 2)->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('purchase_order_id')
                  ->references('purchase_orders_id')
                  ->on('purchase_orders')
                  ->onDelete('cascade');

            $table->foreign('material_id')
                  ->references('material_id')
                  ->on('material')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};