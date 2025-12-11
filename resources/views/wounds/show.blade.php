@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Wound Details</h1>

    <div class="border p-4 rounded shadow">
        <img src="{{ asset('storage/'.$wound->image_path) }}" alt="Wound Image" class="w-full h-64 object-cover rounded mb-2">
        <p><strong>Class:</strong> {{ $wound->class }}</p>
        <p><strong>Notes:</strong> {{ $wound->notes ?? '-' }}</p>
        <p><strong>Created At:</strong> {{ $wound->created_at }}</p>
        <a href="{{ route('wounds.index') }}" class="text-blue-500">Back to Wounds</a>
    </div>
</div>
@endsection
