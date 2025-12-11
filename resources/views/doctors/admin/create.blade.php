@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2>Tambah Dokter Baru</h2>
    <form action="{{ route('admin.doctors.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label>User:</label>
            <select name="user_id" class="border p-2 w-full">
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Spesialisasi:</label>
            <input type="text" name="specialization" class="border p-2 w-full">
        </div>
        <div class="mb-4">
            <label>Telepon:</label>
            <input type="text" name="phone" class="border p-2 w-full">
        </div>
        <div class="mb-4">
            <label>Deskripsi:</label>
            <textarea name="description" class="border p-2 w-full"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('admin.doctors.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
    </form>
</div>
@endsection