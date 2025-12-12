<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DoctorAppointmentController extends Controller
{
    public function dashboard()
    {
        // Dapatkan user yang login
        $user = Auth::user();
        
        // Cek jika user bukan dokter
        if ($user->role !== 'doctor') {
            return redirect()->route('home')->with('error', 'Hanya dokter yang dapat mengakses halaman ini.');
        }
        
        // Dapatkan atau buat profil dokter
        $doctor = Doctor::firstOrCreate(
            ['user_id' => $user->id],
            [
                'specialization' => 'Dokter Umum',
                'phone' => $user->phone ?? '',
                'description' => ''
            ]
        );
        
        // Tambahkan full_name jika belum ada
        if (empty($doctor->full_name)) {
            $doctor->full_name = $user->name;
            $doctor->save();
        }
        
        // Dapatkan appointment untuk dokter ini
        $appointments = Appointment::with('user')
            ->where('doctor_id', $doctor->id)
            ->orderBy('scheduled_at', 'asc')
            ->get();
        
        // Hitung statistik
        $stats = [
            'pending' => $appointments->where('status', 'pending')->count(),
            'approved' => $appointments->where('status', 'approved')->count(),
            'cancelled' => $appointments->where('status', 'cancelled')->count(),
            'rescheduled' => $appointments->where('status', 'rescheduled')->count(),
            'completed' => $appointments->where('status', 'completed')->count(),
            'total_patients' => $appointments->unique('user_id')->count(),
        ];
        
        return view('doctors.dashboard', [
            'appointments' => $appointments,
            'stats' => $stats,
            'doctor' => $doctor
        ]);
    }
    
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        
        if ($user->role !== 'doctor') {
            return redirect()->back()->with('error', 'Unauthorized.');
        }
        
        $doctor = $user->doctor;
        
        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }
        
        $appointment = Appointment::findOrFail($id);
        
        // Cek apakah appointment milik dokter ini
        if ($appointment->doctor_id !== $doctor->id) {
            return redirect()->back()->with('error', 'Appointment tidak ditemukan.');
        }
        
        $request->validate([
            'status' => 'required|in:pending,approved,cancelled,rescheduled,completed',
            'scheduled_at' => 'nullable|date',
            'reason' => 'nullable|string|max:500',
        ]);
        
        $appointment->status = $request->status;
        
        if ($request->scheduled_at) {
            $appointment->scheduled_at = $request->scheduled_at;
        }
        
        if ($request->reason) {
            $appointment->reason = $request->reason;
        }
        
        $appointment->save();
        
        return redirect()->back()->with('success', 'Status appointment berhasil diperbarui.');
    }
    
    public function complete($id)
    {
        $user = Auth::user();
        
        if ($user->role !== 'doctor') {
            return redirect()->back()->with('error', 'Unauthorized.');
        }
        
        $doctor = $user->doctor;
        
        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }
        
        $appointment = Appointment::findOrFail($id);
        
        if ($appointment->doctor_id !== $doctor->id) {
            return redirect()->back()->with('error', 'Appointment tidak ditemukan.');
        }
        
        $appointment->status = 'completed';
        $appointment->save();
        
        return redirect()->back()->with('success', 'Appointment telah diselesaikan.');
    }
    
    public function getStats()
    {
        $user = Auth::user();
        
        if ($user->role !== 'doctor') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $doctor = $user->doctor;
        
        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }
        
        $stats = [
            'pending' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'pending')
                ->count(),
            'approved' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'approved')
                ->count(),
            'cancelled' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'cancelled')
                ->count(),
            'total_patients' => Appointment::where('doctor_id', $doctor->id)
                ->distinct('user_id')
                ->count('user_id'),
        ];
        
        return response()->json($stats);
    }
}