<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Doctor;
use App\Models\DoctorSchedule;

class DoctorScheduleSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama dengan aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DoctorSchedule::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $doctors = Doctor::all();
        
        if ($doctors->isEmpty()) {
            $this->command->info('Tidak ada dokter yang ditemukan. Jalankan DoctorSeeder terlebih dahulu!');
            return;
        }
        
        // SESUAIKAN DENGAN ENUM DI MIGRATION: Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $times = [
            ['08:00', '12:00'],
            ['13:00', '17:00'],
            ['09:00', '16:00'],
            ['10:00', '15:00'],
            ['14:00', '18:00'],
        ];
        
        $this->command->info('Menambahkan jadwal untuk ' . $doctors->count() . ' dokter...');
        
        foreach ($doctors as $doctor) {
            // Setiap dokter punya 3-5 jadwal
            $scheduleCount = rand(3, 5);
            
            for ($i = 0; $i < $scheduleCount; $i++) {
                $dayIndex = $i % count($days);
                $timeIndex = $i % count($times);
                
                DoctorSchedule::create([
                    'doctor_id' => $doctor->id,
                    'day' => $days[$dayIndex],
                    'start_time' => $times[$timeIndex][0],
                    'end_time' => $times[$timeIndex][1],
                ]);
            }
            
            $this->command->info('✓ Ditambahkan ' . $scheduleCount . ' jadwal untuk Dr. ' . $doctor->user->name);
        }
        
        $this->command->info('Selesai! Total ' . DoctorSchedule::count() . ' jadwal dokter telah ditambahkan.');
    }
}