<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['email' => 'doctor@example.com'],
            ['name' => 'Doctor User', 'password' => Hash::make('password'), 'role' => 'doctor']
        );

        User::firstOrCreate(
            ['email' => 'patient@example.com'],
            ['name' => 'Patient User', 'password' => Hash::make('password'), 'role' => 'patient']
        );
    }
}
