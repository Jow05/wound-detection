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
        
        // Data centers of excellence
        $centers = [
            [
                'name' => 'Pondok Indah Heart Centre',
                'icon' => 'fas fa-heartbeat',
                'description' => 'Pelayanan jantung dan pembuluh darah yang komprehensif dengan teknologi terkini.',
                'specialists' => '15 Spesialis'
            ],
            [
                'name' => 'Siloam & Arthroplasty Centre',
                'icon' => 'fas fa-bone',
                'description' => 'Pusat unggulan untuk operasi penggantian sendi dan ortopedi.',
                'specialists' => '12 Spesialis'
            ],
            [
                'name' => 'Orthopedic Centre',
                'icon' => 'fas fa-wheelchair',
                'description' => 'Pelayanan ortopedi lengkap dengan dokter spesialis berpengalaman.',
                'specialists' => '18 Spesialis'
            ],
            [
                'name' => 'Klinik Kulit & Kecantikan',
                'icon' => 'fas fa-spa',
                'description' => 'Perawatan kulit dan kecantikan dengan teknologi modern.',
                'specialists' => '8 Spesialis'
            ],
            [
                'name' => 'Jakarta Spine Clinic (JSC)',
                'icon' => 'fas fa-spine',
                'description' => 'Pusat tulang belakang dengan penanganan terintegrasi.',
                'specialists' => '10 Spesialis'
            ],
            [
                'name' => 'Jakarta Knee & Shoulder Orthopedic Sport Centre (JKSOC)',
                'icon' => 'fas fa-running',
                'description' => 'Spesialis cedera olahraga pada lutut dan bahu.',
                'specialists' => '7 Spesialis'
            ]
        ];
        
        // Data untuk semua user
        $data = [
            'isLoggedIn' => Auth::check(),
            'user' => $user,
            'centers' => $centers,
            'doctors' => Doctor::with('user')->limit(6)->get(), // Batasi untuk home page
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
        
        return view('home', $data);
    }
}