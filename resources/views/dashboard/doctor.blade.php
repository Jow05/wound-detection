@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6 text-green-600">Doctor Dashboard</h1>
    <p class="text-gray-600 mb-4">Welcome, Dr. {{ Auth::user()->name }}!</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <h3 class="font-bold text-lg mb-2">Appointments</h3>
            <p class="text-gray-600">Today's Appointments: 0</p>
            <p class="text-gray-600">Pending: 0</p>
            <p class="text-gray-600">Upcoming: 0</p>
        </div>
        
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <h3 class="font-bold text-lg mb-2">Patients</h3>
            <p class="text-gray-600">Total Patients: 0</p>
            <p class="text-gray-600">New Patients: 0</p>
        </div>
        
        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
            <h3 class="font-bold text-lg mb-2">Quick Actions</h3>
            <ul class="space-y-2">
                <li><a href="#" class="text-yellow-600 hover:text-yellow-800">View Schedule</a></li>
                <li><a href="#" class="text-yellow-600 hover:text-yellow-800">Patient Records</a></li>
                <li><a href="#" class="text-yellow-600 hover:text-yellow-800">Prescriptions</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
