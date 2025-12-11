@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="text-center py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-6">Medical Appointment System</h1>
    <p class="text-lg text-gray-600 mb-8">Simple and efficient medical appointment management</p>
    
    <div class="flex justify-center space-x-4">
        @auth
            <a href="{{ route('dashboard') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                Login
            </a>
            <a href="{{ route('register') }}" 
               class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
                Register
            </a>
        @endauth
    </div>
</div>
@endsection