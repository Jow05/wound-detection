@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2>Detail Dokter</h2>
    
    <div class="mb-4">
        <a href="{{ route('admin.doctors.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Dokter
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Informasi User</h3>
            <p class="text-gray-600">Nama: {{ $doctor->user->name }}</p>
            <p class="text-gray-600">Email: {{ $doctor->user->email }}</p>
        </div>
        
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Informasi Dokter</h3>
            <p class="text-gray-600">Spesialisasi: {{ $doctor->specialization }}</p>
            <p class="text-gray-600">Telepon: {{ $doctor->phone }}</p>
            <p class="text-gray-600">Deskripsi: {{ $doctor->description }}</p>
        </div>
        
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Jadwal Praktek</h3>
            @if($doctor->schedules->isNotEmpty())
                <ul class="list-disc list-inside">
                    @foreach($doctor->schedules as $schedule)
                    <li class="text-gray-600">
                        {{ $schedule->day }}: {{ $schedule->start_time }} - {{ $schedule->end_time }}
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">Belum ada jadwal praktek</p>
            @endif
        </div>
        
        <div class="flex space-x-4 mt-6">
            <a href="{{ route('admin.doctors.edit', $doctor->id) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Edit
            </a>
            <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
                        onclick="return confirm('Yakin ingin menghapus dokter ini?')">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection