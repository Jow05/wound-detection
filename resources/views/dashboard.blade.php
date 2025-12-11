<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Pasien - Selamat datang, {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Total Doctors -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dokter Tersedia</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $doctors->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Upcoming Appointments -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Appointment Mendatang</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $upcomingAppointments->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Wounds -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Foto Luka Terbaru</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $recentWounds->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Doctors List -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                Daftar Dokter Tersedia
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Pilih dokter untuk membuat appointment atau melihat jadwal
                            </p>
                        </div>
                        
                        <div class="p-6">
                            @if($doctors->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($doctors as $doctor)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-semibold text-gray-800 dark:text-gray-200">{{ $doctor->user->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    {{ $doctor->specialization ?? 'General Practitioner' }}
                                                </p>
                                                @if($doctor->phone)
                                                <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                                                    📞 {{ $doctor->phone }}
                                                </p>
                                                @endif
                                            </div>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                {{ $doctor->schedules->count() }} jadwal
                                            </span>
                                        </div>
                                        
                                        @if($doctor->schedules->count() > 0)
                                        <div class="mt-3">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Jadwal Praktek:</p>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($doctor->schedules->take(2) as $schedule)
                                                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 px-2 py-1 rounded">
                                                    {{ substr($schedule->day, 0, 3) }} {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                                </span>
                                                @endforeach
                                                @if($doctor->schedules->count() > 2)
                                                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 px-2 py-1 rounded">
                                                    +{{ $doctor->schedules->count() - 2 }} lainnya
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="mt-4 flex space-x-2">
                                            <a href="{{ route('patient.doctors.show', $doctor->id) }}" 
                                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded text-sm font-medium transition duration-200">
                                                Lihat Detail
                                            </a>
                                            <a href="{{ route('patient.doctors.appointments.create', $doctor->id) }}" 
                                               class="flex-1 border border-blue-600 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 text-center py-2 px-4 rounded text-sm font-medium transition duration-200">
                                                Buat Appointment
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-6 text-center">
                                    <a href="{{ route('patient.doctors.index') }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Lihat semua dokter
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada dokter tersedia</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Upcoming Appointments -->
                    @if($upcomingAppointments->count() > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                Appointment Mendatang
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($upcomingAppointments as $appointment)
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                Dr. {{ $appointment->doctor->user->name }}
                                            </h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $appointment->scheduled_at->format('d M Y') }} • {{ $appointment->scheduled_at->format('H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Right Column - Quick Actions & Recent Wounds -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                Aksi Cepat
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('patient.doctors.index') }}" 
                                   class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition duration-200">
                                    <div class="flex-shrink-0 h-8 w-8 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Cari Dokter</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('wounds.create') }}" 
                                   class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition duration-200">
                                    <div class="flex-shrink-0 h-8 w-8 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center">
                                        <svg class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Upload Foto Luka</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('appointments.index') }}" 
                                   class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition duration-200">
                                    <div class="flex-shrink-0 h-8 w-8 bg-purple-100 dark:bg-purple-800 rounded-lg flex items-center justify-center">
                                        <svg class="h-5 w-5 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Lihat Appointment</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Wounds -->
                    @if($recentWounds->count() > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Foto Luka Terbaru
                                </h3>
                                <a href="{{ route('wounds.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    Lihat semua
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($recentWounds as $wound)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($wound->image_path)
                                        <div class="h-12 w-12 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                                            <img src="{{ asset('storage/' . $wound->image_path) }}" 
                                                 alt="Foto luka" 
                                                 class="h-full w-full object-cover">
                                        </div>
                                        @else
                                        <div class="h-12 w-12 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $wound->created_at->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Klasifikasi: {{ ucfirst($wound->class) }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>