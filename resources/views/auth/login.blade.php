@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="email">Email</label>
            <input type="email" name="email" id="email" 
                   class="w-full px-3 py-2 border rounded-lg @error('email') border-red-500 @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2" for="password">Password</label>
            <input type="password" name="password" id="password" 
                   class="w-full px-3 py-2 border rounded-lg @error('password') border-red-500 @enderror"
                   required>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg">
            Login
        </button>
        
        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">
                Don't have an account? Register
            </a>
        </div>
    </form>
</div>
@endsection