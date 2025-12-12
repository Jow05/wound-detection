<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        
        // Cara 1: Ambil user yang belum menjadi dokter (manual query)
        $doctorUserIds = Doctor::pluck('user_id')->toArray();
        $users = User::whereNotIn('id', $doctorUserIds)->get();
        
        // Cara 2: Atau jika mau filter hanya user dengan role tertentu
        // $users = User::whereNotIn('id', $doctorUserIds)
        //              ->whereIn('role', ['doctor', 'patient']) // optional filter
        //              ->get();
        
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

        // Update user role menjadi 'doctor' jika perlu
        $user = User::find($request->user_id);
        if ($user) {
            $user->update(['role' => 'doctor']);
        }

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function show(Doctor $doctor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $doctor->load('user', 'appointments', 'schedules');
        return view('doctors.admin.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        // Ambil semua user yang belum menjadi dokter ATAU user dokter ini
        $doctorUserIds = Doctor::where('id', '!=', $doctor->id)->pluck('user_id')->toArray();
        $users = User::whereNotIn('id', $doctorUserIds)
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

        // Update user role jika user_id berubah
        if ($doctor->user_id != $request->user_id) {
            // Reset role user lama jika tidak menjadi dokter lagi
            $oldUser = User::find($doctor->user_id);
            if ($oldUser && Doctor::where('user_id', $oldUser->id)->count() == 0) {
                $oldUser->update(['role' => 'patient']); // atau sesuai kebutuhan
            }
            
            // Update role user baru menjadi doctor
            $newUser = User::find($request->user_id);
            if ($newUser) {
                $newUser->update(['role' => 'doctor']);
            }
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        // Reset role user jika perlu
        $user = User::find($doctor->user_id);
        if ($user) {
            $user->update(['role' => 'patient']);
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
        
        // PERBAIKAN: Tambahkan eager loading dan pagination yang benar
        $doctors = Doctor::with(['user', 'schedules'])
            ->whereHas('user', function($query) {
                $query->where('role', 'doctor'); // Filter hanya user dengan role 'doctor'
            })
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