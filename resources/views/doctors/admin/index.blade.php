@extends('layouts.app')

@section('title', 'Manage Doctors - Admin Panel')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Manage Doctors</h1>
            <p class="text-gray-600">Kelola data dokter di sistem klinik</p>
        </div>
        <a href="{{ route('admin.doctors.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center">
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah Dokter Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Doctors Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if($doctors->isEmpty())
            <div class="p-8 text-center">
                <i class="fas fa-user-md text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada data dokter</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan dokter baru.</p>
                <a href="{{ route('admin.doctors.create') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg">
                    <i class="fas fa-plus mr-2"></i>Tambah Dokter Pertama
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-4 px-6 text-left text-gray-700 font-semibold">Nama Dokter</th>
                            <th class="py-4 px-6 text-left text-gray-700 font-semibold">Email</th>
                            <th class="py-4 px-6 text-left text-gray-700 font-semibold">Spesialisasi</th>
                            <th class="py-4 px-6 text-left text-gray-700 font-semibold">Telepon</th>
                            <th class="py-4 px-6 text-left text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($doctors as $doctor)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user-md text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $doctor->user->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $doctor->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-gray-700">{{ $doctor->user->email }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $doctor->specialization ?? 'General' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-gray-700">{{ $doctor->phone ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.doctors.show', $doctor->id) }}" 
                                       class="text-blue-600 hover:text-blue-800 p-2 rounded hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}" 
                                       class="text-yellow-600 hover:text-yellow-800 p-2 rounded hover:bg-yellow-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 p-2 rounded hover:bg-red-50">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Stats -->
            <div class="border-t border-gray-100 px-6 py-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Total <span class="font-semibold">{{ $doctors->count() }}</span> dokter
                    </div>
                    <div class="text-sm text-gray-600">
                        @if(method_exists($doctors, 'hasPages') && $doctors->hasPages())
                            {{ $doctors->links() }}
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection