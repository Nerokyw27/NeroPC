<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin NeroPC',
            'email' => 'admin@neropc.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // Customer
        User::create([
            'name' => 'Customer NeroPC',
            'email' => 'customer@neropc.com',
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);
    }
}
