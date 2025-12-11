<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    // =========================
    // CRUD untuk admin
    // =========================

    public function index()
    {
        // Hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mengakses halaman ini.');
        }
        
        $doctors = Doctor::with('user')->get();
        return view('doctors.admin.index', compact('doctors'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        // Ambil user yang belum punya role dokter
        $users = User::whereDoesntHave('doctor')->get();
        return view('doctors.admin.create', compact('users'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $validated = $request->validate([
            'user_id' => 'required|unique:doctors,user_id',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function show(Doctor $doctor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $doctor->load('user', 'appointments');
        return view('doctors.admin.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        // Ambil semua user yang belum punya doctor atau user dokter ini
        $users = User::whereDoesntHave('doctor')
                     ->orWhere('id', $doctor->user_id)
                     ->get();
        return view('doctors.admin.edit', compact('doctor', 'users'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $validated = $request->validate([
            'user_id' => 'required|unique:doctors,user_id,' . $doctor->id,
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $doctor->delete();
        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil dihapus.');
    }

    // =========================
    // Method untuk pasien
    // =========================

    /**
     * Tampilkan semua dokter + jadwal untuk pasien
     */
    public function listForPatients()
    {
        // Hanya pasien yang bisa akses
        if (Auth::user()->role !== 'patient') {
            abort(403, 'Hanya pasien yang bisa mengakses halaman ini.');
        }
        
        // Gunakan paginate() untuk pagination support
        $doctors = Doctor::with(['user', 'schedules'])
            ->orderBy('id', 'desc')
            ->paginate(9); // 9 dokter per halaman
        
        return view('doctors.patient.index', compact('doctors'));
    }

    /**
     * Tampilkan detail dokter + jadwal appointment pasien
     */
    public function showForPatients($doctorId)
    {
        if (Auth::user()->role !== 'patient') {
            abort(403);
        }
        
        $doctor = Doctor::with(['user', 'schedules'])->findOrFail($doctorId);
        
        // Ambil appointment pasien dengan dokter ini
        $appointments = Appointment::where('user_id', Auth::id())
            ->where('doctor_id', $doctorId)
            ->latest()
            ->get();

        return view('doctors.patient.show', compact('doctor', 'appointments'));
    }
}