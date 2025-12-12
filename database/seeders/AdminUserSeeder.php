<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User', 
                'password' => Hash::make('password'), 
                'role' => 'admin'
            ]
        );

        // Doctor user - BUAT DOCTOR MODEL JUGA
        $doctorUser = User::firstOrCreate(
            ['email' => 'doctor@example.com'],
            [
                'name' => 'Dr. Test Dokter', 
                'password' => Hash::make('password'), 
                'role' => 'doctor'
            ]
        );
        
        // BUAT DOCTOR MODEL UNTUK USER INI
        Doctor::firstOrCreate(
            ['user_id' => $doctorUser->id],
            [
                'specialization' => 'Spesialis Umum',
                'phone' => '0812-3456-7890',
                'description' => 'Dokter tes untuk sistem development'
            ]
        );

        // Patient
        User::firstOrCreate(
            ['email' => 'patient@example.com'],
            [
                'name' => 'Patient User', 
                'password' => Hash::make('password'), 
                'role' => 'patient'
            ]
        );
        
        $this->command->info('✓ Admin, Doctor, and Patient users created successfully');
        $this->command->info('✓ Doctor profile created for doctor@example.com');
    }
}