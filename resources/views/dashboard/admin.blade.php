@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">Admin Dashboard</h1>
    <p class="text-gray-600 mb-4">Welcome, {{ Auth::user()->name }}!</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <h3 class="font-bold text-lg mb-2">Quick Stats</h3>
            <p class="text-gray-600">Total Users: 0</p>
            <p class="text-gray-600">Total Doctors: 0</p>
            <p class="text-gray-600">Total Patients: 0</p>
        </div>
        
        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <h3 class="font-bold text-lg mb-2">Quick Actions</h3>
            <ul class="space-y-2">
                <li><a href="#" class="text-green-600 hover:text-green-800">Manage Users</a></li>
                <li><a href="#" class="text-green-600 hover:text-green-800">View Reports</a></li>
                <li><a href="#" class="text-green-600 hover:text-green-800">System Settings</a></li>
            </ul>
        </div>
        
        <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
            <h3 class="font-bold text-lg mb-2">Admin Tools</h3>
            <ul class="space-y-2">
                <li><a href="#" class="text-purple-600 hover:text-purple-800">User Management</a></li>
                <li><a href="#" class="text-purple-600 hover:text-purple-800">Role Permissions</a></li>
                <li><a href="#" class="text-purple-600 hover:text-purple-800">Audit Logs</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
