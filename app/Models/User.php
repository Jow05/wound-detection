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
        'role',
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
    
    // Relationship dengan Doctor (jika user adalah dokter)
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
    
    // Relationship dengan appointments (jika user adalah patient)
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    // Relationship dengan wounds (jika user adalah patient)
    public function wounds()
    {
        return $this->hasMany(Wound::class);
    }
    
    // Relationship dengan feedbacks
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}