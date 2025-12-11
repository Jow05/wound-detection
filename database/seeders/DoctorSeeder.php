<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada dengan aman
        // Jangan truncate langsung karena ada foreign key constraints
        
        // Cara 1: Delete biasa (lebih aman)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Doctor::truncate();
        
        // Juga hapus user dokter yang sudah ada
        User::where('role', 'doctor')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Atau cara 2: Hapus manual tanpa truncate
        // Doctor::query()->delete();
        // User::where('role', 'doctor')->delete();
        
        // Buat beberapa user dokter
        $doctorUsers = [
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'budi@example.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Sari Wijaya',
                'email' => 'sari@example.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Ahmad Fauzi',
                'email' => 'ahmad@example.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Maya Sari',
                'email' => 'maya@example.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Rudi Hartono',
                'email' => 'rudi@example.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Lisa Anggraeni',
                'email' => 'lisa@example.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
            ],
        ];
        
        $this->command->info('Membuat user dokter...');
        
        foreach ($doctorUsers as $doctorUser) {
            $user = User::create($doctorUser);
            
            // Buat data dokter
            $specializations = [
                'Spesialis Jantung',
                'Spesialis Ortopedi', 
                'Spesialis Kulit & Kecantikan',
                'Spesialis Anak',
                'Dokter Umum',
                'Spesialis Bedah',
                'Spesialis Mata',
                'Spesialis THT',
            ];
            
            $descriptions = [
                'Dokter spesialis dengan pengalaman 10+ tahun, berdedikasi memberikan pelayanan terbaik.',
                'Ahli di bidangnya dengan pendekatan holistik terhadap kesehatan pasien.',
                'Berkompeten dalam diagnosis dan penanganan penyakit dengan teknologi terkini.',
                'Fokus pada pencegahan dan pengobatan dengan perhatian penuh pada pasien.',
                'Bersertifikasi internasional dengan metode pengobatan modern.',
                'Berpengalaman di rumah sakit besar dengan ribuan pasien terlayani.',
            ];
            
            $phones = [
                '0812-3456-7890',
                '0813-4567-8901', 
                '0814-5678-9012',
                '0815-6789-0123',
                '0816-7890-1234',
                '0817-8901-2345',
            ];
            
            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $specializations[array_rand($specializations)],
                'phone' => $phones[array_rand($phones)],
                'description' => $descriptions[array_rand($descriptions)],
            ]);
            
            $this->command->info('✓ Dokter: ' . $user->name);
        }
        
        $this->command->info('Selesai! ' . Doctor::count() . ' dokter telah ditambahkan.');
    }
}