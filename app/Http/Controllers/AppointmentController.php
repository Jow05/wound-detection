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
            ->where('status', '!=', 'cancelled')
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

    // Method untuk approve appointment - PERBAIKAN
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        
        // Check authorization - dokter harus terkait dengan appointment
        if ($user->role !== 'doctor') {
            abort(403, 'Hanya dokter yang dapat melakukan aksi ini.');
        }
        
        // Periksa apakah user punya profil dokter
        if (!$user->doctor) {
            return redirect()->route('doctor.setup')
                ->with('error', 'Silakan lengkapi profil dokter Anda terlebih dahulu.');
        }
        
        // Periksa apakah appointment milik dokter ini
        if ($appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Anda tidak memiliki akses ke appointment ini.');
        }
        
        // Approve appointment
        $appointment->approve();
        
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil disetujui.');
    }

    // Method untuk reject/cancel appointment - PERBAIKAN
    public function reject(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        
        // Check authorization
        if ($user->role !== 'doctor') {
            abort(403, 'Hanya dokter yang dapat melakukan aksi ini.');
        }
        
        if (!$user->doctor) {
            return redirect()->route('doctor.setup')
                ->with('error', 'Silakan lengkapi profil dokter Anda terlebih dahulu.');
        }
        
        if ($appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Anda tidak memiliki akses ke appointment ini.');
        }
        
        // Cancel appointment dengan reason
        $reason = $request->input('reason', 'Dibatalkan oleh dokter');
        $appointment->cancel($reason);
        
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil dibatalkan.');
    }

    // Method untuk complete appointment - PERBAIKAN
    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        
        // Check authorization
        if ($user->role !== 'doctor') {
            abort(403, 'Hanya dokter yang dapat melakukan aksi ini.');
        }
        
        if (!$user->doctor) {
            return redirect()->route('doctor.setup')
                ->with('error', 'Silakan lengkapi profil dokter Anda terlebih dahulu.');
        }
        
        if ($appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Anda tidak memiliki akses ke appointment ini.');
        }
        
        // Complete appointment
        $appointment->complete();
        
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil diselesaikan.');
    }

    // Method untuk reschedule appointment - PERBAIKAN
    public function reschedule(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        
        // Check authorization
        if ($user->role !== 'doctor') {
            abort(403, 'Hanya dokter yang dapat melakukan aksi ini.');
        }
        
        if (!$user->doctor) {
            return redirect()->route('doctor.setup')
                ->with('error', 'Silakan lengkapi profil dokter Anda terlebih dahulu.');
        }
        
        if ($appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Anda tidak memiliki akses ke appointment ini.');
        }
        
        $request->validate([
            'new_scheduled_at' => 'required|date|after:now',
            'reason' => 'required|string|max:500',
        ]);
        
        // Reschedule appointment
        $appointment->reschedule($request->new_scheduled_at, $request->reason);
        
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil dijadwalkan ulang.');
    }

    // Method cancel untuk pasien - PERBAIKAN
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
        
        // Cancel appointment
        $appointment->cancel('Dibatalkan oleh pasien');
        
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil dibatalkan.');
    }
}