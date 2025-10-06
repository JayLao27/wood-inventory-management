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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id('material_id');
            $table->unsignedBigInteger('finished_product_id');
            $table->unsignedBigInteger('reference_id');
            $table->string('item_id');
            $table->string('item_type');
            $table->string('movement_type');
            $table->decimal('quantity', 10, 2);
            $table->string('reference_type');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Add indexes if needed
            $table->index(['item_id', 'item_type']);
            $table->index('reference_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
