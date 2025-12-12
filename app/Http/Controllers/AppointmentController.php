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
            // CEK APAKAH DOCTOR ADA
            if (!$user->doctor || !$user->doctor->exists) {
                return redirect()->route('doctor.setup')
                    ->with('error', 'Silakan lengkapi profil dokter Anda terlebih dahulu.');
            }
            
            // Dokter hanya lihat appointment mereka sendiri
            // Gunakan scope dari Model jika ada
            $appointments = Appointment::with('user', 'doctor')
                ->where('doctor_id', $user->doctor->id)
                ->orderBy('scheduled_at', 'asc')
                ->paginate(10);
                
            return view('appointments.doctor_index', compact('appointments'));
        } else {
            // Pasien lihat appointment mereka sendiri
            $appointments = Appointment::with('doctor.user')
                ->where('user_id', $user->id)
                ->orderBy('scheduled_at', 'asc')
                ->paginate(10);
                
            return view('appointments.index', compact('appointments'));
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

    // Method untuk approve appointment
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        
        // Check authorization - dokter harus terkait dengan appointment
        if ($user->role !== 'doctor' || $appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // PAKAI METHOD DARI MODEL (jika ada) atau manual update
        if (method_exists($appointment, 'approve')) {
            $appointment->approve();
        } else {
            $appointment->status = 'approved';
            $appointment->save();
        }
        
        return back()->with('success', 'Appointment approved successfully.');
    }

    // Method untuk reject/cancel appointment
    public function reject(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        
        // Check authorization
        if ($user->role !== 'doctor' || $appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // PAKAI METHOD DARI MODEL (jika ada) atau manual update
        if (method_exists($appointment, 'cancel')) {
            $appointment->cancel($request->reason ?? 'Cancelled by doctor');
        } else {
            $appointment->status = 'cancelled';
            $appointment->reason = $request->reason ?? 'Cancelled by doctor';
            $appointment->save();
        }
        
        return back()->with('success', 'Appointment cancelled.');
    }

    // Method untuk complete appointment
    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        
        // Check authorization
        if ($user->role !== 'doctor' || $appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // PAKAI METHOD DARI MODEL (jika ada) atau manual update
        if (method_exists($appointment, 'complete')) {
            $appointment->complete();
        } else {
            $appointment->status = 'completed';
            $appointment->save();
        }
        
        return back()->with('success', 'Appointment marked as completed.');
    }

    // Method untuk reschedule appointment
    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'new_scheduled_at' => 'required|date|after:now',
            'reason' => 'required|string|max:500',
        ]);
        
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        
        // Check authorization
        if ($user->role !== 'doctor' || $appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // PAKAI METHOD DARI MODEL (jika ada) atau manual update
        if (method_exists($appointment, 'reschedule')) {
            $appointment->reschedule($request->new_scheduled_at, $request->reason);
        } else {
            $appointment->scheduled_at = Carbon::parse($request->new_scheduled_at);
            $appointment->status = 'rescheduled';
            $appointment->reason = $request->reason;
            $appointment->save();
        }
        
        return back()->with('success', 'Appointment rescheduled successfully.');
    }

    // Method cancel untuk pasien
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
        
        // PAKAI METHOD DARI MODEL (jika ada) atau manual update
        if (method_exists($appointment, 'cancel')) {
            $appointment->cancel('Cancelled by patient');
        } else {
            $appointment->update(['status' => 'cancelled', 'reason' => 'Cancelled by patient']);
        }
        
        return back()->with('success', 'Appointment dibatalkan.');
    }
}