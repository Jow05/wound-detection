<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'thread_id',
        'message',
        'image_path',
    ];

    // Relasi ke User (pengirim)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Thread
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
