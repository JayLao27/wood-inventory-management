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
        Schema::table('sales_orders', function (Blueprint $table) {
            \DB::statement("ALTER TABLE sales_orders MODIFY COLUMN status ENUM('In production', 'Confirmed', 'Pending', 'Delivered', 'Ready', 'Cancelled') DEFAULT 'Pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            \DB::statement("ALTER TABLE sales_orders MODIFY COLUMN status ENUM('In production', 'Confirmed', 'Pending', 'Delivered', 'Ready') DEFAULT 'Pending'");
        });
    }

};
