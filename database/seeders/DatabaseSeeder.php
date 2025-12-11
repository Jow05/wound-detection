<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class, // Seeder untuk admin
            DoctorSeeder::class,     // Seeder untuk dokter
            DoctorScheduleSeeder::class, // Seeder untuk jadwal dokter
        ]);
        
        // Jika ingin buat user patient dummy juga
        // \App\Models\User::factory(10)->create(['role' => 'patient']);
    }
}