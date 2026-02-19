<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('sales_order_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('product_name')->nullable(); // Kept for flexibility
            $table->integer('quantity');
            $table->integer('completion_quantity')->default(0);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'overdue', 'cancelled'])->default('pending');
            $table->date('due_date');
            $table->date('starting_date')->nullable();
            $table->string('assigned_to');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};