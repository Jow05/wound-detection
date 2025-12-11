@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Luka Anda</h2>

    <a href="{{ route('wounds.create') }}" style="margin-bottom:15px; display:inline-block;">Upload Luka Baru</a>

    @if (session('success'))
        <div style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Foto</th>
            <th>Kelas</th>
            <th>Catatan</th>
            <th>Tanggal</th>
        </tr>

        @foreach ($wounds as $wound)
        <tr>
            <td>
                <img src="{{ asset('storage/' . $wound->image_path) }}" width="100">
            </td>
            <td>{{ ucfirst($wound->class) }}</td>
            <td>{{ $wound->notes }}</td>
            <td>{{ $wound->created_at->format('d-m-Y H:i') }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
