@extends('layouts.app')

@section('header')
<h2 class="mb-4">Buat Appointment</h2>
@endsection

@section('content')
<div class="container mx-auto p-4">
    @if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('patient.appointments.store', $doctor->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Dokter:</label>
            <input type="text" value="{{ $doctor->user->name }}" class="border p-2 w-full" disabled>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Tanggal & Waktu:</label>
            <input type="datetime-local" name="scheduled_at" class="border p-2 w-full" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buat Appointment</button>
        <a href="{{ route('patient.doctors.show', $doctor->id) }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
    </form>
</div>
@endsection
