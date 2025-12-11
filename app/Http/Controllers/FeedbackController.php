<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'doctor') {
            // Dokter bisa lihat semua feedback
            $feedbacks = Feedback::with('user')->latest()->get();
        } else {
            // Pasien hanya lihat feedback sendiri
            $feedbacks = Feedback::where('user_id', $user->id)->latest()->get();
        }

        return view('feedbacks.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('feedbacks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'feedback' => 'required|string|min:10|max:1000',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil dikirim!');
    }

    public function show(Feedback $feedback)
    {
        // Cek authorization
        if (Auth::user()->role !== 'doctor' && $feedback->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('feedbacks.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        // Hanya pemilik atau admin yang bisa hapus
        if ($feedback->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $feedback->delete();
        return redirect()->route('feedbacks.index')->with('success', 'Feedback dihapus.');
    }
}