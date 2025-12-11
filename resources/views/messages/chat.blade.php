@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Chat</h1>

    <div class="border p-4 rounded h-96 overflow-y-scroll mb-4">
        <p><strong>Doctor:</strong> Hello, how is your wound?</p>
        <p><strong>Patient:</strong> Here is the picture.</p>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="message" placeholder="Type a message" class="border p-2 w-full mb-2">
        <input type="file" name="image" class="mb-2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>
    </form>
</div>
@endsection
