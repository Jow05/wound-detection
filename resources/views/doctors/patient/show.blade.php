@extends('layouts.app')

@section('title', 'Detail Dokter - RS Pondok Indah')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('patient.doctors.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Dokter
        </a>
    </div>

    <!-- Doctor Profile Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <!-- Doctor Header -->
        <div class="bg-gradient-to-r from-blue-600 to-teal-600 p-8 text-white">
            <div class="flex flex-col md:flex-row md:items-center">
                <!-- Doctor Avatar -->
                <div class="mb-6 md:mb-0 md:mr-8">
                    <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center border-4 border-white/30">
                        <i class="fas fa-user-md text-5xl"></i>
                    </div>
                </div>
                
                <!-- Doctor Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">Dr. {{ $doctor->user->name }}</h1>
                    <p class="text-xl font-semibold mb-4">{{ $doctor->specialization ?? 'Spesialis Umum' }}</p>
                    
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-300 mr-2"></i>
                            <span class="font-semibold">4.8/5.0</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-briefcase-medical mr-2"></i>
                            <span>10+ Tahun Pengalaman</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>Spesialis</span>
                        </div>
                    </div>
                </div>
                
                <!-- Action Button -->
                <div class="mt-6 md:mt-0">
                    <a href="{{ route('appointments.create', $doctor->id) }}" 
                       class="inline-flex items-center bg-white text-blue-600 hover:bg-blue-50 font-bold py-3 px-6 rounded-lg transition">
                        <i class="fas fa-calendar-plus mr-2"></i> Buat Janji
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Doctor Details -->
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: About & Contact -->
                <div class="lg:col-span-2">
                    <!-- About Doctor -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user-md text-blue-500 mr-3"></i>Tentang Dokter
                        </h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 mb-4">
                                {{ $doctor->description ?? 'Dokter berpengalaman dengan komitmen memberikan pelayanan kesehatan terbaik kepada pasien.' }}
                            </p>
                            
                            <div class="bg-blue-50 p-6 rounded-lg">
                                <h3 class="font-bold text-gray-800 mb-3">Keahlian Khusus:</h3>
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    <li>Konsultasi kesehatan lengkap</li>
                                    <li>Diagnosis dan penanganan tepat</li>
                                    <li>Pemantauan kesehatan berkala</li>
                                    <li>Edukasi kesehatan untuk pasien</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-address-card text-blue-500 mr-3"></i>Informasi Kontak
                        </h2>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-envelope text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="font-semibold text-gray-800">{{ $doctor->user->email }}</p>
                                    </div>
                                </div>
                                
                                @if($doctor->phone)
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-phone text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Telepon</p>
                                        <p class="font-semibold text-gray-800">{{ $doctor->phone }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-hospital text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Lokasi Praktek</p>
                                        <p class="font-semibold text-gray-800">RS Pondok Indah</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-clock text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Waktu Respons</p>
                                        <p class="font-semibold text-gray-800">1-2 Jam Kerja</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Schedule & Quick Actions -->
                <div>
                    <!-- Practice Schedule -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-3"></i>Jadwal Praktek
                        </h2>
                        
                        @if($doctor->schedules->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($doctor->schedules as $schedule)
                            <div class="border-l-4 border-blue-500 pl-4 py-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-gray-800 capitalize">{{ $schedule->day }}</p>
                                        <p class="text-sm text-gray-600">{{ $schedule->location ?? 'Klinik Utama' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-blue-600">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </p>
                                        <p class="text-xs text-gray-500">Waktu Praktek</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-6">
                            <i class="fas fa-calendar-times text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Jadwal praktek belum tersedia</p>
                        </div>
                        @endif
                        
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                <span>Janji temu harus dibuat minimal 24 jam sebelumnya</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Appointment -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Buat Janji Cepat</h3>
                        <p class="text-gray-600 mb-4">Pilih waktu yang tersedia untuk konsultasi dengan dokter.</p>
                        
                        <a href="{{ route('appointments.create', $doctor->id) }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center mb-3 transition">
                            <i class="fas fa-calendar-plus mr-2"></i> Buat Janji Sekarang
                        </a>
                        
                        <div class="text-center">
                            <p class="text-sm text-gray-500">atau</p>
                            <button class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                <i class="fas fa-phone-alt mr-1"></i> Hubungi 1500-123
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Patient's Appointments with this Doctor -->
    @if(isset($appointments) && $appointments->isNotEmpty())
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Janji Saya dengan Dokter Ini</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Tanggal & Waktu</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr class="border-t border-gray-100">
                        <td class="py-4 px-4">
                            <div class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d F Y') }}
                            </div>
                            <div class="text-gray-600">
                                {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('H:i') }} WIB
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            @if($appointment->status == 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i> Menunggu Konfirmasi
                            </span>
                            @elseif($appointment->status == 'approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i> Dikonfirmasi
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times mr-1"></i> Ditolak
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if($appointment->status == 'pending')
                            <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 text-sm font-semibold"
                                        onclick="return confirm('Yakin ingin membatalkan janji ini?')">
                                    <i class="fas fa-trash-alt mr-1"></i> Batalkan
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .prose {
        color: #374151;
    }
    
    .prose p {
        margin-bottom: 1rem;
    }
    
    .prose ul {
        list-style-type: disc;
        margin-left: 1.5rem;
    }
</style>
@endpush
@endsection