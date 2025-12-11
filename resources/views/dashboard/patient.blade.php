@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">Patient Dashboard</h1>
    <p class="text-gray-600 mb-4">Welcome, {{ Auth::user()->name }}!</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <h3 class="font-bold text-lg mb-2">My Appointments</h3>
            <p class="text-gray-600">Upcoming: 0</p>
            <p class="text-gray-600">Pending: 0</p>
            <p class="text-gray-600">Past: 0</p>
        </div>
        
        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <h3 class="font-bold text-lg mb-2">Medical Records</h3>
            <p class="text-gray-600">Wound Photos: 0</p>
            <p class="text-gray-600">Prescriptions: 0</p>
        </div>
        
        <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
            <h3 class="font-bold text-lg mb-2">Quick Actions</h3>
            <ul class="space-y-2">
                <li><a href="#" class="text-purple-600 hover:text-purple-800">Book Appointment</a></li>
                <li><a href="#" class="text-purple-600 hover:text-purple-800">Upload Wound Photo</a></li>
                <li><a href="#" class="text-purple-600 hover:text-purple-800">View Doctors</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection