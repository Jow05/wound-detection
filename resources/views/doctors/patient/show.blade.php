@extends('layouts.app')

@section('header')
<h2 class="mb-4">Detail Dokter</h2>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-3">
    <div class="card-header">{{ $doctor->user->name }}</div>
    <div class="card-body">
        <p><strong>Email:</strong> {{ $doctor->user->email }}</p>
        <p><strong>Spesialisasi:</strong> {{ $doctor->specialization }}</p>
        <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
        <p><strong>Description:</strong> {{ $doctor->description }}</p>
    </div>
</div>

<h4>Jadwal Appointment</h4>
@if($appointments->count() > 0)
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal & Waktu</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($appointments as $appt)
        <tr>
            <td>{{ $appt->scheduled_at }}</td>
            <td>{{ ucfirst($appt->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Belum ada jadwal appointment.</p>
@endif

<a href="{{ route('patient.appointments.create', $doctor->id) }}" class="btn btn-success mt-3">Buat Appointment</a>
<a href="{{ route('patient.doctors.list') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Dokter</a>
@endsection
