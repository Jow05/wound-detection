@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Create Feedback</h1>

    <form action="#" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Feedback:</label>
            <textarea name="feedback" class="border p-2 w-full" rows="4"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Feedback</button>
    </form>
</div>
@endsection
