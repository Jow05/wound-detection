@extends('layouts.app')

@section('header')
<h2 class="mb-4">Add Doctor</h2>
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('doctors.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select name="user_id" class="form-control" required>
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="specialization" class="form-label">Specialization</label>
        <input type="text" name="specialization" class="form-control">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>
@endsection
