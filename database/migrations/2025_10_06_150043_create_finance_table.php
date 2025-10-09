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
        Schema::create('finance', function (Blueprint $table) {
            $table->id('finance_id');
            $table->string('record_type'); // Income, Expense
            $table->string('reference_id')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('status')->nullable(); // Approved, Pending, Rejected
            $table->string('recorded_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->date('record_date');
            $table->date('approval_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance');
    }
};