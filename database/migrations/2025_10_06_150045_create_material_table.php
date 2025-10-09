<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material', function (Blueprint $table) {
            $table->id('material_id');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('current_stock', 10, 2)->default(0);
            $table->decimal('minimum_stock', 10, 2)->default(0);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material');
    }
};
