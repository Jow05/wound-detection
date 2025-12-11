@extends('layouts.app')

@section('header')
<h2 class="mb-4">Doctor Details</h2>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-header">{{ $doctor->user->name }}</div>
    <div class="card-body">
        <p><strong>Email:</strong> {{ $doctor->user->email }}</p>
        <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
        <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
        <p><strong>Description:</strong> {{ $doctor->description }}</p>
    </div>
</div>

<a href="{{ route('doctors.index') }}" class="btn btn-primary">Back to List</a>
@endsection
