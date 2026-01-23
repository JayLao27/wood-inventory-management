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
            $table->int('transaction_type');

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
