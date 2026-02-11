<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For MySQL: Modify the enum to include 'cancelled'
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE work_orders MODIFY status ENUM('pending', 'in_progress', 'quality_check', 'completed', 'overdue', 'cancelled') NOT NULL DEFAULT 'pending'");
        }
        // For other databases, you might need different syntax
    }

    public function down(): void
    {
        // Revert the enum to the original set (removing 'cancelled')
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE work_orders MODIFY status ENUM('pending', 'in_progress', 'quality_check', 'completed', 'overdue') NOT NULL DEFAULT 'pending'");
        }
    }
};
