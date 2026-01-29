<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Attach materials to products (BOM - Bill of Materials).
 * Products 1–5 and materials 1–6 from MaterialSeeder / ProductSeeder.
 */
class ProductMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $productMaterials = [
            // Oak Dining Table (product 1) – oak lumber, maple plywood, walnut veneer, wood stain
            1 => [
                ['material_id' => 1, 'quantity_needed' => 25],   // Oak Lumber (board_ft)
                ['material_id' => 2, 'quantity_needed' => 2],    // Maple Plywood (sheet)
                ['material_id' => 3, 'quantity_needed' => 15],    // Walnut Veneer (sq_ft)
                ['material_id' => 6, 'quantity_needed' => 0.5],    // Wood Stain (gallon)
            ],
            // Maple Kitchen Cabinet (product 2)
            2 => [
                ['material_id' => 2, 'quantity_needed' => 3],
                ['material_id' => 4, 'quantity_needed' => 8],
                ['material_id' => 6, 'quantity_needed' => 0.25],
            ],
            // Walnut Coffee Table (product 3)
            3 => [
                ['material_id' => 1, 'quantity_needed' => 12],
                ['material_id' => 3, 'quantity_needed' => 8],
                ['material_id' => 6, 'quantity_needed' => 0.2],
            ],
            // Pine Bookshelf (product 4)
            4 => [
                ['material_id' => 4, 'quantity_needed' => 15],
                ['material_id' => 2, 'quantity_needed' => 1],
                ['material_id' => 6, 'quantity_needed' => 0.3],
            ],
            // Cherry Wood Doors (product 5)
            5 => [
                ['material_id' => 1, 'quantity_needed' => 20],
                ['material_id' => 4, 'quantity_needed' => 6],
                ['material_id' => 3, 'quantity_needed' => 10],
                ['material_id' => 6, 'quantity_needed' => 0.4],
            ],
        ];

        foreach ($productMaterials as $productId => $materials) {
            $product = Product::find($productId);
            if (!$product) {
                continue;
            }
            $product->materials()->detach();
            foreach ($materials as $row) {
                $product->materials()->attach($row['material_id'], [
                    'quantity_needed' => $row['quantity_needed'],
                ]);
            }
        }
    }
}
