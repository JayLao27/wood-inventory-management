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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transactions_id');
            $table->unsignedBigInteger('reference_id');
            $table->string('transaction_number')->unique();
            $table->string('type'); // Income, Expense
            $table->date('category')->nullable();
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->decimal('reference_type', 10, 2)->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};