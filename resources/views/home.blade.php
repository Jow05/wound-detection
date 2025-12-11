@extends('layouts.app')

@section('title', 'Clinic System')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            # Pertama di Indonesia, tiga rumah sakit  
            <span class="text-blue-600">Evergreen Health & Wellness Center</span>  
            meraih validasi
        </h1>
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-8">
            HIMSS EMRAM Tingkat 7
        </h2>
        
        @if(!$isLoggedIn)
        <div class="flex justify-center space-x-4 mb-12">
            <a href="{{ route('login') }}" 
               class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-300">
                Login
            </a>
            <a href="{{ route('register') }}" 
               class="bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-green-700 transition duration-300">
                Register
            </a>
        </div>
        @endif
    </div>

    <!-- EMRAM Section -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-16">
        <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">EMRAM</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 border border-gray-200 rounded-lg">
                <div class="text-blue-500 text-4xl mb-4">📄</div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Paperless Environment</h4>
                <p class="text-gray-600">Lingkungan bebas kertas</p>
            </div>
            
            <div class="text-center p-6 border border-gray-200 rounded-lg">
                <div class="text-green-500 text-4xl mb-4">🔒</div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Data Security</h4>
                <p class="text-gray-600">Keamanan data terjamin</p>
            </div>
            
            <div class="text-center p-6 border border-gray-200 rounded-lg">
                <div class="text-purple-500 text-4xl mb-4">📊</div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Advanced Analytics</h4>
                <p class="text-gray-600">Analitik data canggih</p>
            </div>
        </div>
    </div>

    <!-- Cari Dokter Section -->
    <div class="mb-16">
        <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">Cari Dokter</h3>
        
        @if($doctors->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-600">Belum ada dokter yang tersedia</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($doctors as $doctor)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $doctor->user->name }}</h4>
                        <p class="text-gray-600 mb-3">
                            <span class="font-semibold">Spesialisasi:</span> 
                            {{ $doctor->specialization ?? 'General' }}
                        </p>
                        
                        @if($isLoggedIn && auth()->user()->role === 'patient')
                        <div class="mt-4 flex space-x-3">
                            <a href="{{ route('doctors.show', $doctor->id) }}" 
                               class="flex-1 bg-blue-500 text-white text-center py-2 rounded hover:bg-blue-600">
                                Detail
                            </a>
                            <a href="{{ route('appointments.create', $doctor->id) }}" 
                               class="flex-1 bg-green-500 text-white text-center py-2 rounded hover:bg-green-600">
                                Buat Janji
                            </a>
                        </div>
                        @elseif(!$isLoggedIn)
                        <div class="mt-4">
                            <a href="{{ route('login') }}" 
                               class="block w-full bg-gray-500 text-white text-center py-2 rounded hover:bg-gray-600">
                                Login untuk buat janji
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Patient Dashboard (Hanya tampil jika user patient sudah login) -->
    @if($isLoggedIn && auth()->user()->role === 'patient')
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-lg p-8 mb-16">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-bold text-gray-800">Patient Dashboard</h3>
            <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-semibold">
                Welcome, {{ auth()->user()->name }}
            </span>
        </div>

        <!-- My Appointments Section -->
        <div class="mb-8">
            <h4 class="text-xl font-bold text-gray-800 mb-4">My Appointments</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $upcomingAppointments ?? 0 }}</div>
                    <div class="text-gray-700 font-semibold">Upcoming</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $pendingAppointments ?? 0 }}</div>
                    <div class="text-gray-700 font-semibold">Pending</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-3xl font-bold text-gray-600 mb-2">0</div>
                    <div class="text-gray-700 font-semibold">Past</div>
                </div>
            </div>
            
            <!-- List Appointments -->
            @if(isset($appointments) && $appointments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Dokter</th>
                            <th class="py-3 px-4 text-left">Tanggal</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr class="border-t">
                            <td class="py-3 px-4">{{ $appointment->doctor->user->name }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d M Y, H:i') }}</td>
                            <td class="py-3 px-4">
                                @if($appointment->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                                @elseif($appointment->status == 'approved')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Approved</span>
                                @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Rejected</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($appointment->status == 'pending')
                                <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        Cancel
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Medical Records & Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">Medical Records</h4>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <span>Wound Photos:</span>
                        <span class="font-bold">{{ $wounds->count() ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Prescriptions:</span>
                        <span class="font-bold">0</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h4>
                <div class="space-y-3">
                    <a href="{{ route('doctors.index') }}" 
                       class="block w-full bg-blue-500 text-white text-center py-3 rounded-lg hover:bg-blue-600">
                        Book Appointment
                    </a>
                    <a href="{{ route('wounds.create') }}" 
                       class="block w-full bg-green-500 text-white text-center py-3 rounded-lg hover:bg-green-600">
                        Upload Wound Photo
                    </a>
                    <a href="{{ route('doctors.index') }}" 
                       class="block w-full bg-purple-500 text-white text-center py-3 rounded-lg hover:bg-purple-600">
                        View Doctors
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Untuk Dokter yang login -->
    @if($isLoggedIn && auth()->user()->role === 'doctor')
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl shadow-lg p-8 mb-16">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Doctor Dashboard</h3>
        <p class="text-gray-600 mb-4">Welcome, Dr. {{ auth()->user()->name }}</p>
        <a href="{{ route('appointments.index') }}" 
           class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
            View My Appointments
        </a>
    </div>
    @endif

    <!-- Untuk Admin yang login -->
    @if($isLoggedIn && auth()->user()->role === 'admin')
    <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl shadow-lg p-8 mb-16">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Admin Dashboard</h3>
        <p class="text-gray-600 mb-4">Welcome, Admin {{ auth()->user()->name }}</p>
        <a href="{{ route('admin.doctors.index') }}" 
           class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 mr-3">
            Manage Doctors
        </a>
    </div>
    @endif
</div>
@endsection