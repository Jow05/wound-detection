@extends('layouts.app')

@section('title', 'RS Pondok Indah - Home')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-900 to-teal-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Pertama di Indonesia,<br>
                tiga rumah sakit<br>
                <span class="text-yellow-300">RS Pondok Indah Group</span><br>
                meraih validasi<br>
                HIMSS EMRAM Tingkat 7
            </h1>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Standar tertinggi sistem informasi rumah sakit secara global
            </p>
            
            @if(!auth()->check())
            <div class="flex justify-center space-x-4">
                <a href="{{ route('register') }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-blue-900 font-bold px-8 py-3 rounded-lg text-lg">
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-900 text-white font-bold px-8 py-3 rounded-lg text-lg">
                    Login
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- EMRAM Certification -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">EMRAM</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-alt text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Paperless Environment</h3>
                <p class="text-gray-600">Lingkungan bebas kertas</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shield-alt text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Data Security</h3>
                <p class="text-gray-600">Keamanan data terjamin</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chart-line text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Advanced Analytics</h3>
                <p class="text-gray-600">Analitik data canggih</p>
            </div>
        </div>
    </div>
</section>

<!-- Center of Excellence -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Center of Excellence</h2>
        <p class="text-gray-600 text-center mb-12 max-w-3xl mx-auto">
            Tersedia berbagai informasi terkini mengenai pelayanan kesehatan kami, di sini.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($centers as $center)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="{{ $center['icon'] }} text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $center['name'] }}</h3>
                    </div>
                    <p class="text-gray-600 mb-4">{{ $center['description'] }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-blue-600 font-semibold">
                            <i class="fas fa-user-md mr-1"></i> {{ $center['specialists'] }}
                        </span>
                        @if(auth()->check() && auth()->user()->role === 'patient')
                        <a href="{{ route('patient.doctors.index') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Buat Janji <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Accreditation & Awards -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Akreditasi & Penghargaan</h2>
        <p class="text-gray-600 text-center mb-12 max-w-3xl mx-auto">
            Berbagai pengakuan tertinggi dari lembaga akreditasi global untuk komitmen kami dalam memberikan pelayanan kesehatan terbaik, mengutamakan keamanan dan kenyamanan Anda.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">HIMSS EMRAM Tingkat 7</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <i class="fas fa-award text-yellow-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-bold text-gray-800">Orthopedic Best Specialized Hospital Asia Pacific 2023</h4>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-award text-yellow-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-bold text-gray-800">Best Specialized Hospital Asia Pacific 2023 - Cardiology</h4>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-award text-yellow-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-bold text-gray-800">Best Specialized Hospital Asia Pacific 2023 - Pediatric</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Akses Pelayanan Kami Dari Ponsel Anda</h3>
                <p class="text-gray-600 mb-6">
                    Unduh aplikasi RSPI Mobile. Aplikasi terintegrasi untuk memudahkan Anda mengakses layanan kami. Informasi lebih lengkap tentang aplikasi kami ada di sini.
                </p>
                <div class="flex space-x-4">
                    <button class="flex items-center bg-black text-white px-6 py-3 rounded-lg">
                        <i class="fab fa-apple text-2xl mr-3"></i>
                        <div class="text-left">
                            <div class="text-xs">Download on the</div>
                            <div class="font-bold">App Store</div>
                        </div>
                    </button>
                    <button class="flex items-center bg-green-600 text-white px-6 py-3 rounded-lg">
                        <i class="fab fa-google-play text-2xl mr-3"></i>
                        <div class="text-left">
                            <div class="text-xs">Get it on</div>
                            <div class="font-bold">Google Play</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Patient Dashboard (Hanya untuk logged in patient) -->
@if(auth()->check() && auth()->user()->role === 'patient')
<section class="py-16 bg-gradient-to-br from-blue-50 to-teal-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="md:flex">
                <!-- Sidebar -->
                <div class="md:w-1/4 bg-blue-900 text-white p-8">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-blue-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-injured text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold">{{ auth()->user()->name }}</h3>
                        <p class="text-blue-200">Pasien</p>
                    </div>
                    
                    <nav class="space-y-4">
                        <a href="{{ route('patient.doctors.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-800 {{ Request::is('patient/doctors*') ? 'bg-blue-800' : '' }}">
                            <i class="fas fa-user-md mr-3"></i>
                            <span>Cari Dokter</span>
                        </a>
                        <a href="{{ route('appointments.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-800 {{ Request::is('appointments*') ? 'bg-blue-800' : '' }}">
                            <i class="fas fa-calendar-check mr-3"></i>
                            <span>Janji Saya</span>
                        </a>
                        <a href="{{ route('wounds.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-800 {{ Request::is('wounds*') ? 'bg-blue-800' : '' }}">
                            <i class="fas fa-band-aid mr-3"></i>
                            <span>Foto Luka</span>
                        </a>
                    </nav>
                </div>
                
                <!-- Main Content -->
                <div class="md:w-3/4 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Pasien</h2>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-800">{{ $upcomingAppointments ?? 0 }}</div>
                                    <div class="text-gray-600">Janji Mendatang</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-100">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-800">{{ $pendingAppointments ?? 0 }}</div>
                                    <div class="text-gray-600">Menunggu Konfirmasi</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 p-6 rounded-lg border border-green-100">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-images text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-800">{{ $wounds->count() ?? 0 }}</div>
                                    <div class="text-gray-600">Foto Luka</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('patient.doctors.index') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-md mr-3"></i>
                                <span>Buat Janji dengan Dokter</span>
                            </a>
                            <a href="{{ route('wounds.create') }}" 
                               class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg flex items-center justify-center">
                                <i class="fas fa-camera mr-3"></i>
                                <span>Upload Foto Luka</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Locations -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Lokasi Kami</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hospital text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">RS Pondok Indah - Pondok Indah</h3>
                <p class="text-gray-600">Jl. Metro Duta Kav. UE, Pondok Indah, Jakarta Selatan</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hospital text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">RS Pondok Indah - Puri Indah</h3>
                <p class="text-gray-600">Jl. Puri Indah Raya Blok S-1, Puri Indah, Jakarta Barat</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hospital text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">RS Pondok Indah - Bintaro Jaya</h3>
                <p class="text-gray-600">Jl. Bintaro Taman Barat Blok F-1, Bintaro Jaya, Tangerang Selatan</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Custom styles for hospital theme */
    .hospital-gradient {
        background: linear-gradient(135deg, #1e3a8a 0%, #0f766e 100%);
    }
    
    .shadow-soft {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
</style>
@endpush