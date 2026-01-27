<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'product_name' => 'Oak Dining Table',
            'description' => 'Beautiful solid oak dining table, seats 6-8',
            'category' => 'furniture',
            'production_cost' => 350.00,
            'selling_price' => 750.00,
            'current_stock' => 15,
            'minimum_stock' => 5,
            'unit' => 'piece',
            'status' => 'active',
        ]);

        Product::create([
            'product_name' => 'Maple Kitchen Cabinet',
            'description' => 'Premium maple wood kitchen cabinet',
            'category' => 'cabinets',
            'production_cost' => 200.00,
            'selling_price' => 450.00,
            'current_stock' => 8,
            'minimum_stock' => 3,
            'unit' => 'piece',
            'status' => 'active',
        ]);

        Product::create([
            'product_name' => 'Walnut Coffee Table',
            'description' => 'Modern walnut wood coffee table',
            'category' => 'furniture',
            'production_cost' => 150.00,
            'selling_price' => 350.00,
            'current_stock' => 20,
            'minimum_stock' => 8,
            'unit' => 'piece',
            'status' => 'active',
        ]);

        Product::create([
            'product_name' => 'Pine Bookshelf',
            'description' => 'Tall pine bookshelf with 5 shelves',
            'category' => 'furniture',
            'production_cost' => 120.00,
            'selling_price' => 280.00,
            'current_stock' => 12,
            'minimum_stock' => 4,
            'unit' => 'piece',
            'status' => 'active',
        ]);

        Product::create([
            'product_name' => 'Cherry Wood Doors',
            'description' => 'Custom cherry wood door frame',
            'category' => 'doors',
            'production_cost' => 180.00,
            'selling_price' => 420.00,
            'current_stock' => 6,
            'minimum_stock' => 2,
            'unit' => 'piece',
            'status' => 'active',
        ]);
    }
}
