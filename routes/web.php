<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WoundController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===================
// HOME PAGE (UNTUK SEMUA)
// ===================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===================
// AUTH ROUTES
// ===================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ===================
// PROTECTED ROUTES
// ===================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ===================
    // PROFILE
    // ===================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===================
// DOCTORS (ADMIN ONLY)
// ===================
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('doctors', DoctorController::class)->except(['show']);
        Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    });

    // ===================
    // APPOINTMENTS
    // ===================
    Route::prefix('appointments')->group(function() {
        Route::get('/', [AppointmentController::class, 'index'])->name('appointments.index');
        
        // Untuk patient
        Route::get('/create/{doctor}', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/store/{doctor}', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::post('/cancel/{appointment}', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

        // Untuk doctor
        Route::post('/confirm/{appointment}', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::post('/reject/{appointment}', [AppointmentController::class, 'reject'])->name('appointments.reject');
        Route::post('/complete/{appointment}', [AppointmentController::class, 'complete'])->name('appointments.complete');
    });

    // ===================
    // FEEDBACK
    // ===================
    Route::resource('feedbacks', FeedbackController::class);

    // ===================
    // MESSAGE
    // ===================
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/chat/{id}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // ===================
    // WOUND
    // ===================
    Route::resource('wounds', WoundController::class);
    
    // ===================
    // DOCTORS FOR PATIENTS
    // ===================
    // Route untuk daftar dokter (patient)
    Route::get('/patient/doctors', [DoctorController::class, 'listForPatients'])->name('patient.doctors.index');
    
    // Route untuk detail dokter (patient)
    Route::get('/patient/doctors/{doctor}', [DoctorController::class, 'showForPatients'])->name('patient.doctors.show');
});