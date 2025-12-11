<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wound extends Model
{
    protected $fillable = [
        'user_id',
        'image_path',
        'class',
        'notes',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
