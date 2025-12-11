@extends('layouts.app')

@section('header')
<h2 class="mb-4">Doctors</h2>
@endsection

@section('content')
<a href="{{ route('doctors.create') }}" class="btn btn-success mb-3">Add Doctor</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Specialization</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($doctors as $doctor)
        <tr>
            <td>{{ $doctor->user->name }}</td>
            <td>{{ $doctor->specialization }}</td>
            <td>{{ $doctor->phone }}</td>
            <td>
                <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
