<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('user_id', Auth::id())
                          ->orWhereHas('thread', function($query) {
                              $query->where('participants', 'like', '%"' . Auth::id() . '"%');
                          })
                          ->latest()
                          ->get();
                          
        return view('messages.index', compact('messages'));
    }

    public function chat($id)
    {
        // Cek apakah user punya akses ke thread ini
        $messages = Message::where('thread_id', $id)
                          ->where(function($query) {
                              $query->where('user_id', Auth::id())
                                    ->orWhereHas('thread', function($q) {
                                        $q->where('participants', 'like', '%"' . Auth::id() . '"%');
                                    });
                          })
                          ->get();
                          
        if ($messages->isEmpty()) {
            abort(403);
        }
        
        return view('messages.chat', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'thread_id' => 'required|exists:threads,id',
        ]);

        $path = $request->file('image')?->store('messages', 'public');

        Message::create([
            'user_id' => Auth::id(),
            'thread_id' => $request->thread_id,
            'message' => $request->message,
            'image_path' => $path,
        ]);

        return back()->with('success', 'Pesan terkirim.');
    }

    public function destroy(Message $message)
    {
        // Hanya pengirim yang bisa hapus pesan
        if ($message->user_id !== Auth::id()) {
            abort(403);
        }
        
        $message->delete();
        return back()->with('success', 'Pesan dihapus.');
    }
}