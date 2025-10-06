<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id('sales_orders_id'); // Custom primary key
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('payment_status')->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sales_orders');
    }
};

