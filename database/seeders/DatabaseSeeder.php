<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@ecomm.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Demo customer
        User::create([
            'name'     => 'John Traveler',
            'email'    => 'customer@ecomm.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
        ]);

        $this->call(ProductSeeder::class);
    }
}
