@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload Foto Luka</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('wounds.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom:10px;">
            <label>Foto Luka:</label><br>
            <input type="file" name="image" required>
        </div>

        <div style="margin-bottom:10px;">
            <label>Kelas Luka:</label><br>
            <select name="class" required>
                <option value="clean">Clean</option>
                <option value="clean-contaminated">Clean-Contaminated</option>
                <option value="contaminated">Contaminated</option>
                <option value="infected">Infected</option>
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label>Catatan:</label><br>
            <textarea name="notes" rows="3"></textarea>
        </div>

        <button type="submit">Upload</button>
    </form>
</div>
@endsection
