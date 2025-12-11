<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Wound;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('doctors.index');
        } 
        elseif ($user->role === 'doctor') {
            return redirect()->route('appointments.index');
        }
        
        // Hanya patient yang sampai sini
        // Ambil semua dokter dengan user & jadwal
        $doctors = Doctor::with(['user', 'schedules'])->get();
        
        // Ambil appointment mendatang pasien
        $appointments = Appointment::with('doctor.user')
            ->where('user_id', $user->id)
            ->where('scheduled_at', '>=', now())
            ->where('status', 'pending')
            ->orderBy('scheduled_at', 'asc')
            ->limit(3)
            ->get();
            
        // Ambil luka terbaru
        $wounds = Wound::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('dashboard', compact('doctors', 'appointments', 'wounds'));
    }
}