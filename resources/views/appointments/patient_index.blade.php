@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">My Appointments</h1>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Dokter</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->doctor->user->name ?? '-' }}</td>
                <td>{{ $appointment->scheduled_at->format('d M Y H:i') }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
