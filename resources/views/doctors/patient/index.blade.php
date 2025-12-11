@extends('layouts.app')

@section('header')
<h2 class="mb-4">Daftar Dokter</h2>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Spesialisasi</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($doctors as $doctor)
        <tr>
            <td>{{ $doctor->user->name }}</td>
            <td>{{ $doctor->specialization }}</td>
            <td>{{ $doctor->phone }}</td>
            <td>
                <a href="{{ route('patient.doctors.show', $doctor->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
