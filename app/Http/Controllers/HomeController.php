<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Wound;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Data untuk semua user
        $data = [
            'isLoggedIn' => Auth::check(),
            'user' => $user,
        ];
        
        // Jika user sudah login, tambahkan data spesifik
        if ($user) {
            if ($user->role === 'patient') {
                $data['appointments'] = Appointment::with('doctor.user')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->limit(5)
                    ->get();
                    
                $data['wounds'] = Wound::where('user_id', $user->id)
                    ->latest()
                    ->limit(3)
                    ->get();
                    
                $data['upcomingAppointments'] = Appointment::where('user_id', $user->id)
                    ->where('status', 'approved')
                    ->where('scheduled_at', '>=', now())
                    ->count();
                    
                $data['pendingAppointments'] = Appointment::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->count();
            }
        }
        
        // Data untuk semua (doctors untuk booking)
        $data['doctors'] = Doctor::with('user')->get();
        
        return view('home', $data);
    }
}