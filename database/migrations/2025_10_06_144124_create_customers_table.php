<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('customer_name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->enum('customer_type', ['Retail', 'Wholesale', 'Contractor'])->default('Retail');
            $table->integer('total_orders')->default(0);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customers');
    }
};