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
    ]
);

User::updateOrCreate(
    ['email' => 'manager@rmwoodworks.com'],
    [
        'name' => 'Manager',
        'password' => Hash::make('manager123'),
    ]
);

User::updateOrCreate(
    ['email' => 'worker@rmwoodworks.com'],
    [
        'name' => 'Worker',
        'password' => Hash::make('worker123'),
    ]
);

    }
}
