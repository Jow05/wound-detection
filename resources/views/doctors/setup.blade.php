@extends('layouts.app')

@section('title', 'Lengkapi Profil Dokter - RS Pondok Indah')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-md text-yellow-600 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Lengkapi Profil Dokter Anda</h1>
            <p class="text-gray-600">Harap lengkapi informasi dokter untuk mengakses sistem</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctor.profile.setup') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Info User (Read Only) -->
                <div class="bg-blue-50 p-6 rounded-lg mb-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Informasi Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Specialization -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Spesialisasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="specialization" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Contoh: Spesialis Jantung, Spesialis Umum, Spesialis Anak"
                           value="{{ old('specialization') }}"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Spesialisasi utama Anda sebagai dokter</p>
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="phone" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Contoh: 0812-3456-7890"
                           value="{{ old('phone') }}"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Nomor yang dapat dihubungi pasien</p>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Profesional
                    </label>
                    <textarea name="description" 
                              rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Deskripsikan keahlian, pengalaman, pendidikan, dan pencapaian Anda...">{{ old('description') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Deskripsi ini akan ditampilkan kepada pasien</p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="px-5 py-2 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                    </a>
                    <button type="submit" 
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Simpan Profil
                    </button>
                </div>
            </div>
        </form>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styling untuk form */
    input:focus, textarea:focus {
        outline: none;
        ring: 2px;
    }
</style>
@endpush