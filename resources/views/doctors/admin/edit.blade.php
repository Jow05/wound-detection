@extends('layouts.app')

@section('header')
<h2 class="mb-4">Edit Doctor</h2>
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select name="user_id" class="form-control" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == $doctor->user_id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="specialization" class="form-label">Specialization</label>
        <input type="text" name="specialization" value="{{ $doctor->specialization }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" value="{{ $doctor->phone }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ $doctor->description }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
</form>
@endsection
