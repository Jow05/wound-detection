<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wound;
use Illuminate\Support\Facades\Auth;

class WoundController extends Controller
{
    /**
     * Tampilkan daftar luka sesuai role
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'doctor') {
            $wounds = Wound::with('user')->latest()->get(); // dokter lihat semua pasien
            return view('wounds.doctor_index', compact('wounds'));
        } elseif ($user->role === 'admin') {
            $wounds = Wound::with('user')->latest()->get(); // admin lihat semua pasien
            return view('wounds.admin_index', compact('wounds'));
        } else {
            // patient
            $wounds = Wound::where('user_id', $user->id)->latest()->get();
            return view('wounds.patient_index', compact('wounds'));
        }
    }

    /**
     * Form untuk upload luka (patient)
     */
    public function create()
    {
        if (Auth::user()->role !== 'patient') {
            abort(403, 'Hanya pasien yang bisa upload foto luka.');
        }
        
        return view('wounds.create');
    }

    /**
     * Simpan foto luka
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // max 5MB
            'class' => 'nullable|in:clean,clean-contaminated,contaminated,infected',
            'notes' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('wounds', 'public');

        Wound::create([
            'user_id' => Auth::id(),
            'image_path' => $path,
            'class' => $request->class ?? 'unknown', // default unknown
            'notes' => $request->notes,
        ]);

        return redirect()->route('wounds.index')->with('success', 'Foto luka berhasil diupload!');
    }

    /**
     * Tampilkan detail luka
     */
    public function show(Wound $wound)
    {
        $user = Auth::user();

        // Cek permission: pasien hanya lihat luka sendiri
        if ($user->role === 'patient' && $wound->user_id !== $user->id) {
            abort(403);
        }

        $wound->load('user');
        return view('wounds.show', compact('wound'));
    }

    /**
     * Update klasifikasi luka (dokter/admin)
     */
    public function updateClass(Request $request, Wound $wound)
    {
        // Hanya dokter atau admin yang bisa update
        if (!in_array(Auth::user()->role, ['doctor', 'admin'])) {
            abort(403);
        }
        
        $request->validate([
            'class' => 'required|in:clean,clean-contaminated,contaminated,infected',
        ]);

        $wound->update([
            'class' => $request->class,
        ]);

        return redirect()->back()->with('success', 'Klasifikasi luka diperbarui.');
    }

    /**
     * Hapus foto luka
     */
    public function destroy(Wound $wound)
    {
        // Hanya pemilik atau admin yang bisa hapus
        if ($wound->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        // Hapus file dari storage
        if ($wound->image_path && \Storage::disk('public')->exists($wound->image_path)) {
            \Storage::disk('public')->delete($wound->image_path);
        }
        
        $wound->delete();
        
        return redirect()->route('wounds.index')->with('success', 'Foto luka dihapus.');
    }
}