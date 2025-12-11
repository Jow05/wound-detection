<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'doctor') {
            // Dokter hanya lihat appointment mereka sendiri
            $appointments = Appointment::with('user', 'doctor')
                ->where('doctor_id', $user->doctor->id)
                ->latest()
                ->get();
            return view('appointments.doctor_index', compact('appointments'));
        } else {
            // Pasien lihat appointment mereka sendiri
            $appointments = Appointment::with('doctor')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
            return view('appointments.patient_index', compact('appointments'));
        }
    }

    public function create(Doctor $doctor)
    {
        // Pastikan hanya pasien yang bisa buat appointment
        if (Auth::user()->role !== 'patient') {
            abort(403, 'Hanya pasien yang bisa membuat appointment.');
        }
        
        return view('appointments.create', compact('doctor'));
    }

    public function store(Request $request, Doctor $doctor)
    {
        // Pastikan hanya pasien
        if (Auth::user()->role !== 'patient') {
            abort(403, 'Hanya pasien yang bisa membuat appointment.');
        }

        $request->validate([
            'scheduled_at' => 'required|date|after:now',
        ]);

        // Cek apakah sudah ada appointment di waktu yang sama
        $existingAppointment = Appointment::where('doctor_id', $doctor->id)
            ->where('scheduled_at', '>=', $request->scheduled_at)
            ->where('scheduled_at', '<=', Carbon::parse($request->scheduled_at)->addHour())
            ->where('status', '!=', 'rejected')
            ->exists();
            
        if ($existingAppointment) {
            return back()->with('error', 'Dokter sudah memiliki appointment di waktu tersebut.');
        }

        Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $doctor->id,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending',
        ]);

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment berhasil dibuat!');
    }

    public function confirm(Appointment $appointment)
    {
        // Hanya dokter yang terkait yang bisa konfirmasi
        if (Auth::id() !== $appointment->doctor->user_id) {
            abort(403);
        }
        
        $appointment->update(['status' => 'approved']);
        
        return back()->with('success', 'Appointment dikonfirmasi!');
    }

    public function reject(Appointment $appointment)
    {
        if (Auth::id() !== $appointment->doctor->user_id) {
            abort(403);
        }
        
        $appointment->update(['status' => 'rejected']);
        
        return back()->with('success', 'Appointment ditolak.');
    }

    public function complete(Appointment $appointment)
    {
        if (Auth::id() !== $appointment->doctor->user_id) {
            abort(403);
        }
        
        // Status lengkap - buat custom jika perlu
        // $appointment->update(['status' => 'completed']);
        return back()->with('info', 'Fitur complete belum diimplementasi.');
    }

    public function cancel(Appointment $appointment)
    {
        // Hanya pasien pemilik appointment yang bisa cancel
        if (Auth::id() !== $appointment->user_id) {
            abort(403);
        }
        
        // Hanya appointment pending yang bisa dicancel
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Hanya appointment pending yang bisa dibatalkan.');
        }
        
        $appointment->update(['status' => 'rejected']);
        
        return back()->with('success', 'Appointment dibatalkan.');
    }
}