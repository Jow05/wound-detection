<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\WoundController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PatientDashboardController;

// ================= PUBLIC ROUTES =================
// Home Page - TAMPILKAN CONTACT PAGE (RS Pondok Indah)
Route::get('/', function () {
    return view('contact'); // <-- INI YANG DIPERBAIKI
})->name('home');

// Contact Pages (PUBLIC - bisa diakses tanpa login)
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/contact-us', function () {
    return view('contact');
})->name('contact.us');

// Auth Routes (for guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout (accessible when logged in)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= PROTECTED ROUTES (Need Login) =================
Route::middleware('auth')->group(function () {
    
    // Main Dashboard Redirect
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
    
    // Role-based Dashboards
    Route::get('/admin/dashboard', function () {
        $user = auth()->user();
        if ($user->role !== 'admin') abort(403);
        return view('dashboard.admin', ['user' => $user]);
    })->name('admin.dashboard');
    
    Route::get('/doctor/dashboard', function () {
        $user = auth()->user();
        if ($user->role !== 'doctor') abort(403);
        return view('dashboard.doctor', ['user' => $user]);
    })->name('doctor.dashboard');
    
    Route::get('/patient/dashboard', function () {
        $user = auth()->user();
        if ($user->role !== 'patient') abort(403);
        return view('dashboard.patient', ['user' => $user]);
    })->name('patient.dashboard');
    
    // Resource Routes
    Route::resource('appointments', AppointmentController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('wounds', WoundController::class);
    Route::resource('feedbacks', FeedbackController::class);
    Route::resource('messages', MessageController::class);
    
    // Appointment actions
    Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
    Route::post('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    
    // Doctor specific routes
    Route::get('/doctors/list/patients', [DoctorController::class, 'listForPatients'])->name('doctors.list.patients');
    Route::get('/doctors/{doctor}/patients', [DoctorController::class, 'showForPatients'])->name('doctors.show.patients');
    
    // Wound actions
    Route::post('/wounds/{wound}/update-class', [WoundController::class, 'updateClass'])->name('wounds.update.class');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});