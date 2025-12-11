@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chat dengan Dokter/Pasien</h2>
    <div id="chat-box" style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:scroll;">
        <!-- Pesan akan muncul di sini -->
    </div>

    <form action="#" method="POST" enctype="multipart/form-data" style="margin-top:10px;">
        @csrf
        <input type="text" name="message" placeholder="Tulis pesan...">
        <input type="file" name="image">
        <button type="submit">Kirim</button>
    </form>
</div>
@endsection
