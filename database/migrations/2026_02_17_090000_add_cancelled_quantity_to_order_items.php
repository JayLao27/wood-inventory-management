<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales_order_items', function (Blueprint $blueprint) {
            $blueprint->integer('cancelled_quantity')->default(0)->after('quantity');
        });

        Schema::table('purchase_order_items', function (Blueprint $blueprint) {
            $blueprint->decimal('cancelled_quantity', 15, 2)->default(0)->after('quantity');
        });
    }

    public function down()
    {
        Schema::table('sales_order_items', function (Blueprint $blueprint) {
            $blueprint->dropColumn('cancelled_quantity');
        });

        Schema::table('purchase_order_items', function (Blueprint $blueprint) {
            $blueprint->dropColumn('cancelled_quantity');
        });
    }
};
