@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">My Wounds</h1>

    @if($wounds->isEmpty())
        <p>You have no wound records.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($wounds as $wound)
            <div class="border p-4 rounded shadow">
                <img src="{{ asset('storage/'.$wound->image_path) }}" alt="Wound Image" class="w-full h-48 object-cover rounded mb-2">
                <p><strong>Class:</strong> {{ $wound->class }}</p>
                <p><strong>Notes:</strong> {{ $wound->notes ?? '-' }}</p>
                <a href="{{ route('wounds.show', $wound->id) }}" class="text-blue-500">View Details</a>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
