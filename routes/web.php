<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Home Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ================= PUBLIC ROUTES =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= PROTECTED ROUTES =================
Route::middleware('auth')->group(function () {
    
    // Main Dashboard Redirect - TANPA MIDDLEWARE ROLE
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role == 'admin') {
            return view('dashboard.admin', ['user' => $user]);
        } elseif ($user->role == 'doctor') {
            return view('dashboard.doctor', ['user' => $user]);
        } elseif ($user->role == 'patient') {
            return view('dashboard.patient', ['user' => $user]);
        }
        
        return redirect('/');
    })->name('dashboard');
    
    // Admin Dashboard - TANPA MIDDLEWARE ROLE DULU
    Route::get('/admin/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized. Admin only.');
        }
        
        return view('dashboard.admin', ['user' => $user]);
    })->name('admin.dashboard');
    
    // Doctor Dashboard
    Route::get('/doctor/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role !== 'doctor') {
            abort(403, 'Unauthorized. Doctor only.');
        }
        
        return view('dashboard.doctor', ['user' => $user]);
    })->name('doctor.dashboard');
    
    // Patient Dashboard
    Route::get('/patient/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role !== 'patient') {
            abort(403, 'Unauthorized. Patient only.');
        }
        
        return view('dashboard.patient', ['user' => $user]);
    })->name('patient.dashboard');
});