@extends('layouts.app')

@section('title', 'Daftar Dokter - RS Pondok Indah')

@section('content')
@php
    // Helper function untuk translate hari
    function translateDay($englishDay) {
        $translations = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa', 
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        return $translations[$englishDay] ?? $englishDay;
    }
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Dokter</h1>
        <p class="text-gray-600">Pilih dokter sesuai dengan kebutuhan kesehatan Anda</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="md:w-2/3">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" 
                           placeholder="Cari dokter berdasarkan nama atau spesialisasi..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="md:w-1/3">
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Spesialisasi</option>
                    <option value="jantung">Jantung</option>
                    <option value="ortopedi">Ortopedi</option>
                    <option value="kulit">Kulit & Kecantikan</option>
                    <option value="anak">Anak</option>
                    <option value="umum">Umum</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Doctors Grid -->
    @if($doctors->isEmpty())
        <div class="bg-white rounded-xl shadow-md p-8 text-center">
            <i class="fas fa-user-md text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada dokter tersedia</h3>
            <p class="text-gray-500">Silakan coba lagi nanti.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($doctors as $doctor)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 card-hover">
                <!-- Doctor Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-start">
                        <!-- Doctor Avatar -->
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user-md text-blue-600 text-2xl"></i>
                        </div>
                        
                        <!-- Doctor Info -->
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Dr. {{ $doctor->user->name }}</h3>
                            <p class="text-blue-600 font-semibold mb-2">
                                {{ $doctor->specialization ?? 'Spesialis Umum' }}
                            </p>
                            <div class="flex items-center text-gray-600 text-sm">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span class="font-semibold">4.8</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-briefcase-medical mr-1"></i>
                                <span>10+ tahun</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Doctor Details -->
                <div class="p-6">
                    <!-- Description -->
                    <p class="text-gray-600 mb-4 line-clamp-2">
                        {{ $doctor->description ?? 'Dokter berpengalaman dengan pelayanan terbaik.' }}
                    </p>
                    
                    <!-- Contact Info -->
                    <div class="space-y-2 mb-4">
                        @if($doctor->phone)
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-phone text-blue-500 w-5 mr-3"></i>
                            <span>{{ $doctor->phone }}</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-envelope text-blue-500 w-5 mr-3"></i>
                            <span>{{ $doctor->user->email }}</span>
                        </div>
                    </div>
                    
                    <!-- Schedules -->
                    @if($doctor->schedules->isNotEmpty())
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                            Jadwal Praktek
                        </h4>
                        <div class="space-y-1">
                            @foreach($doctor->schedules->take(2) as $schedule)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-700 capitalize">{{ translateDay($schedule->day) }}</span>
                                <span class="font-semibold text-blue-600">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </span>
                            </div>
                            @endforeach
                            
                            @if($doctor->schedules->count() > 2)
                            <div class="text-blue-600 text-sm font-semibold mt-1">
                                +{{ $doctor->schedules->count() - 2 }} jadwal lainnya
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="flex space-x-3">
                        <a href="{{ route('patient.doctors.show', $doctor->id) }}" 
                           class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-2 px-4 rounded-lg text-center transition">
                            <i class="fas fa-info-circle mr-2"></i>Detail
                        </a>
                        <a href="{{ route('appointments.create', $doctor->id) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition">
                            <i class="fas fa-calendar-plus mr-2"></i>Buat Janji
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination (jika banyak data) -->
        @if($doctors->hasPages())
        <div class="mt-8">
            {{ $doctors->links() }}
        </div>
        @endif
    @endif
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush
@endsection