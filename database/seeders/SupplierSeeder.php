<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'Premium Oak Suppliers Inc.',
            'contact_person' => 'John Mitchell',
            'phone' => '555-1001',
            'email' => 'sales@oaksuppliers.com',
            'address' => '123 Wood Street, Forest City, WA 98765',
            'payment_terms' => 'Net 30',
            'status' => 'active',
            'total_orders' => 0,
            'total_spent' => 0,
        ]);

        Supplier::create([
            'name' => 'Maple Lumber Co.',
            'contact_person' => 'Sarah Johnson',
            'phone' => '555-1002',
            'email' => 'orders@maplelumber.com',
            'address' => '456 Tree Avenue, Timber Valley, OR 97123',
            'payment_terms' => 'Net 45',
            'status' => 'active',
            'total_orders' => 0,
            'total_spent' => 0,
        ]);

        Supplier::create([
            'name' => 'Exotic Woods Trading',
            'contact_person' => 'Carlos Rodriguez',
            'phone' => '555-1003',
            'email' => 'contact@exoticwoods.com',
            'address' => '789 Walnut Lane, Hardwood City, NC 28202',
            'payment_terms' => 'Net 15',
            'status' => 'active',
            'total_orders' => 0,
            'total_spent' => 0,
        ]);

        Supplier::create([
            'name' => 'Cedar & Pine Mills',
            'contact_person' => 'Emma Davis',
            'phone' => '555-1004',
            'email' => 'wholesale@cedarpinemills.com',
            'address' => '321 Lumber Road, Mill Town, GA 30303',
            'payment_terms' => 'Net 30',
            'status' => 'active',
            'total_orders' => 0,
            'total_spent' => 0,
        ]);
    }
}
