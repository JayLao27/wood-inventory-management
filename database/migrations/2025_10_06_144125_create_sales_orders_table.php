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
   Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
                $table->string('order_number')->unique();
                $table->unsignedBigInteger('customer_id'); // references customers.id
                $table->date('order_date');
                $table->date('delivery_date');
                $table->string('product');
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->enum('status', ['Pending', 'In Production', 'Ready', 'Delivered', 'Cancelled'])->default('Pending');
                $table->enum('payment_status', ['Unpaid', 'Partial', 'Paid'])->default('Unpaid');
                $table->text('notes')->nullable();
                $table->timestamps();

                



                $table->engine = 'InnoDB';
        });

        }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
