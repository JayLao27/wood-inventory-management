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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id('purchase_orders_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('order_number')->unique();
            $table->date('order_date');
            $table->date('expected_delivery');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->string('status')->default('Pending'); // Pending, Completed, Cancelled
            $table->string('assigned_to')->nullable();
            $table->string('quality_status')->nullable();
            $table->string('approved_by')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('updated_date')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('supplier_id')
                  ->references('supplier_id')
                  ->on('suppliers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};