<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the old columns if they exist
            if (Schema::hasColumn('products', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('products', 'unit_price')) {
                $table->dropColumn('unit_price');
            }
            if (Schema::hasColumn('products', 'old_name')) {
                $table->dropColumn('old_name');
            }
            if (Schema::hasColumn('products', 'old_unit_price')) {
                $table->dropColumn('old_unit_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name');
            $table->decimal('unit_price', 12, 2)->default(0);
        });
    }
};