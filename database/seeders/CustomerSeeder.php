<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'ABC Furniture Co.',
            'customer_type' => 'wholesale',
            'phone' => '555-0101',
            'email' => 'info@abcfurniture.com',
        ]);

        Customer::create([
            'name' => 'XYZ Interior Design',
            'customer_type' => 'retail',
            'phone' => '555-0102',
            'email' => 'sales@xyzinterior.com',
        ]);

        Customer::create([
            'name' => 'Local Woodcraft Store',
            'customer_type' => 'retail',
            'phone' => '555-0103',
            'email' => 'contact@localwoodcraft.com',
        ]);

        Customer::create([
            'name' => 'Premium Home Builders',
            'customer_type' => 'wholesale',
            'phone' => '555-0104',
            'email' => 'procurement@premiumhomes.com',
        ]);

        Customer::create([
            'name' => 'Artisan Woodworks LLC',
            'customer_type' => 'wholesale',
            'phone' => '555-0105',
            'email' => 'orders@artisanwood.com',
        ]);
    }
}
