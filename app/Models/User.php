<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // PASTIKAN ADA INI
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function isDoctor()
    {
        return $this->role === 'doctor';
    }
    
    public function isPatient()
    {
        return $this->role === 'patient';
    }
}