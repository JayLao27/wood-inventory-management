<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Demo manager account
      User::updateOrCreate(
    ['email' => 'admin@rmwoodworks.com'],
    [
        'name' => 'Admin',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]
);

User::updateOrCreate(
    ['email' => 'inventory@rmwoodworks.com'],
    [
        'name' => 'Inventory Clerk',
        'password' => Hash::make('inventory123'),
        'role' => 'inventory_clerk',
    ]
);

User::updateOrCreate(
    ['email' => 'procurement@rmwoodworks.com'],
    [
        'name' => 'Procurement Officer',
        'password' => Hash::make('procurement123'),
        'role' => 'procurement_officer',
    ]
);

User::updateOrCreate(
    ['email' => 'workshop@rmwoodworks.com'],
    [
        'name' => 'Workshop Staff',
        'password' => Hash::make('workshop123'),
        'role' => 'workshop_staff',
    ]
);

User::updateOrCreate(
    ['email' => 'sales@rmwoodworks.com'],
    [
        'name' => 'Sales Clerk',
        'password' => Hash::make('sales123'),
        'role' => 'sales_clerk',
    ]
);

User::updateOrCreate(
    ['email' => 'accounting@rmwoodworks.com'],
    [
        'name' => 'Accounting Staff',
        'password' => Hash::make('accounting123'),
        'role' => 'accounting_staff',
    ]
);

        // Run example seeders
        $this->call([
            CustomerSeeder::class,
            ProductSeeder::class,
            SupplierSeeder::class,
            MaterialSeeder::class,
            ProductMaterialSeeder::class, // BOM: materials needed per product
            SalesOrderSeeder::class,
            PurchaseOrderSeeder::class,
            InventoryMovementSeeder::class,
        ]);
    }
}
