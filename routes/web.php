<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WoundController;
// Hapus DoctorAppointmentController jika sudah ada di AppointmentController

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
    // DOCTOR PROFILE SETUP
    // ===================
    Route::get('/doctor/setup', function() {
        if (Auth::user()->role !== 'doctor') {
            abort(403);
        }
        
        if (Auth::user()->doctor && Auth::user()->doctor->exists) {
            return redirect()->route('appointments.index');
        }
        
        return view('doctors.setup');
    })->name('doctor.setup');

    Route::post('/doctor/setup', function(Request $request) {
        if (Auth::user()->role !== 'doctor') {
            abort(403);
        }
        
        $request->validate([
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);
        
        $doctor = Doctor::where('user_id', Auth::id())->first();
        
        if ($doctor) {
            $doctor->update($request->only(['specialization', 'phone', 'description']));
        } else {
            Doctor::create([
                'user_id' => Auth::id(),
                'specialization' => $request->specialization,
                'phone' => $request->phone,
                'description' => $request->description,
            ]);
        }
        
        return redirect()->route('appointments.index')->with('success', 'Profil dokter berhasil disimpan!');
    })->name('doctor.profile.setup');

    // ===================
    // DOCTORS (ADMIN ONLY)
    // ===================
    Route::prefix('admin')->name('admin.')->middleware('can:admin')->group(function() {
        Route::resource('doctors', DoctorController::class)->except(['show']);
        Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    });

    // ===================
    // APPOINTMENTS (UNTUK SEMUA)
    // ===================
    Route::prefix('appointments')->group(function() {
        // Lihat appointments (otomatis redirect berdasarkan role)
        Route::get('/', [AppointmentController::class, 'index'])->name('appointments.index');
        
        // Untuk patient
        Route::get('/create/{doctor}', [AppointmentController::class, 'create'])
            ->name('appointments.create')
            ->middleware('role:patient');
        
        Route::post('/store/{doctor}', [AppointmentController::class, 'store'])
            ->name('appointments.store')
            ->middleware('role:patient');
        
        Route::post('/cancel/{appointment}', [AppointmentController::class, 'cancel'])
            ->name('appointments.cancel')
            ->middleware('role:patient');

        // Untuk doctor - TAMBAHKAN MIDDLEWARE ROLE
        Route::post('/confirm/{appointment}', [AppointmentController::class, 'confirm'])
            ->name('appointments.confirm')
            ->middleware('role:doctor');
        
        Route::post('/reject/{appointment}', [AppointmentController::class, 'reject'])
            ->name('appointments.reject')
            ->middleware('role:doctor');
        
        Route::post('/complete/{appointment}', [AppointmentController::class, 'complete'])
            ->name('appointments.complete')
            ->middleware('role:doctor');
        
        Route::post('/reschedule/{appointment}', [AppointmentController::class, 'reschedule'])
            ->name('appointments.reschedule')
            ->middleware('role:doctor');
    });

    // ===================
    // DOCTOR DASHBOARD ROUTES (OPTIONAL - jika butuh dashboard khusus)
    // ===================
    // Jika tidak butuh dashboard khusus, bisa dihapus
    // Route::middleware('role:doctor')->prefix('doctor')->name('doctor.')->group(function () {
    //     Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    //     // Other doctor routes...
    // });

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
    Route::get('/patient/doctors', [DoctorController::class, 'listForPatients'])
        ->name('patient.doctors.index')
        ->middleware('role:patient');
    
    Route::get('/patient/doctors/{doctor}', [DoctorController::class, 'showForPatients'])
        ->name('patient.doctors.show')
        ->middleware('role:patient');
});