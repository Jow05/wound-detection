@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="name">Full Name</label>
            <input type="text" name="name" id="name" 
                   class="w-full px-3 py-2 border rounded-lg @error('name') border-red-500 @enderror"
                   value="{{ old('name') }}" required autofocus>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="email">Email</label>
            <input type="email" name="email" id="email" 
                   class="w-full px-3 py-2 border rounded-lg @error('email') border-red-500 @enderror"
                   value="{{ old('email') }}" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="password">Password</label>
            <input type="password" name="password" id="password" 
                   class="w-full px-3 py-2 border rounded-lg @error('password') border-red-500 @enderror"
                   required>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="w-full px-3 py-2 border rounded-lg"
                   required>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2" for="role">Register as</label>
            <select name="role" id="role" 
                    class="w-full px-3 py-2 border rounded-lg @error('role') border-red-500 @enderror"
                    required>
                <option value="">Select Role</option>
                <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
            </select>
            @error('role')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" 
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg">
            Register
        </button>
        
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">
                Already have an account? Login
            </a>
        </div>
    </form>
</div>
@endsection