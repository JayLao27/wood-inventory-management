<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('supplier_id');                // Primary key
            $table->string('name');                   // Supplier name
            $table->string('contact_person')->nullable();
            $table->string('phone', 20)->nullable();  // Use string for phone (not int)
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
