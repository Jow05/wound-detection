<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@example.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
        
        User::create([
            'name' => 'Patient User',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
    }
}