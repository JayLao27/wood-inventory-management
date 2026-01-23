<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('accounting', function (Blueprint $table) {
            $table->id();
            $table->string('referenceID');
            $table->string('account_name');
            $table->string('transaction_number');
            $table->integer('transaction_type');
            $table->date('category_date');
            $table->integer('amount');
            $table->string('payment_method');
            $table->string(column: 'description')->nullable();
            $table->date('transaction_date')->nullable();
            $table->string('reference_type')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting');
    }
};
