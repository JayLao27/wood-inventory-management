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
            'phone' => '09171234567',
            'email' => 'info@abcfurniture.com',
        ]);

        Customer::create([
            'name' => 'XYZ Interior Design',
            'customer_type' => 'retail',
            'phone' => '09181234568',
            'email' => 'sales@xyzinterior.com',
        ]);

        Customer::create([
            'name' => 'Local Woodcraft Store',
            'customer_type' => 'retail',
            'phone' => '09191234569',
            'email' => 'contact@localwoodcraft.com',
        ]);

        Customer::create([
            'name' => 'Premium Home Builders',
            'customer_type' => 'wholesale',
            'phone' => '09201234570',
            'email' => 'procurement@premiumhomes.com',
        ]);

        Customer::create([
            'name' => 'Artisan Woodworks LLC',
            'customer_type' => 'wholesale',
            'phone' => '09211234571',
            'email' => 'orders@artisanwood.com',
        ]);
    }
}
