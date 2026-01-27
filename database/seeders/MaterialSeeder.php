<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create([
            'name' => 'Oak Lumber (1x2x8)',
            'category' => 'lumber',
            'unit' => 'board_ft',
            'current_stock' => 500,
            'minimum_stock' => 100,
            'unit_cost' => 5.50,
            'supplier_id' => 1,
        ]);

        Material::create([
            'name' => 'Maple Plywood (3/4")',
            'category' => 'plywood',
            'unit' => 'sheet',
            'current_stock' => 150,
            'minimum_stock' => 30,
            'unit_cost' => 45.00,
            'supplier_id' => 2,
        ]);

        Material::create([
            'name' => 'Walnut Veneer',
            'category' => 'veneer',
            'unit' => 'sq_ft',
            'current_stock' => 300,
            'minimum_stock' => 50,
            'unit_cost' => 8.75,
            'supplier_id' => 3,
        ]);

        Material::create([
            'name' => 'Pine Lumber (2x4x12)',
            'category' => 'lumber',
            'unit' => 'piece',
            'current_stock' => 200,
            'minimum_stock' => 40,
            'unit_cost' => 12.00,
            'supplier_id' => 4,
        ]);

        Material::create([
            'name' => 'Cedar Shingles',
            'category' => 'shingles',
            'unit' => 'bundle',
            'current_stock' => 80,
            'minimum_stock' => 20,
            'unit_cost' => 35.00,
            'supplier_id' => 4,
        ]);

        Material::create([
            'name' => 'Wood Stain (Clear)',
            'category' => 'finishing',
            'unit' => 'gallon',
            'current_stock' => 50,
            'minimum_stock' => 10,
            'unit_cost' => 22.50,
            'supplier_id' => 1,
        ]);
    }
}
