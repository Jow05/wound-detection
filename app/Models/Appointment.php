<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_RESCHEDULED = 'rescheduled';
    const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'user_id',          // Pasien
        'doctor_id',        // Dokter
        'scheduled_at',     // Waktu appointment
        'status',           // Status appointment
        'reason',           // Alasan cancel/reschedule
        'service_type',     // Jenis layanan (optional)
        'complaints',       // Keluhan pasien (optional)
        'notes',            // Catatan tambahan (optional)
        'rescheduled_at',   // Untuk jadwal ulang (optional)
    ];

    // PERBAIKAN: Ganti $dates dengan $casts (Laravel 8+)
    protected $casts = [
        'scheduled_at' => 'datetime',
        'rescheduled_at' => 'datetime',
    ];
    
    protected $appends = ['formatted_date', 'formatted_time']; // Tambahkan ini

    // ====================
    // RELATIONSHIPS
    // ====================
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Alias untuk patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ====================
    // SCOPES
    // ====================
    
    /**
     * Scope untuk appointment dokter tertentu
     */
    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope untuk appointment pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope untuk appointment hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_at', Carbon::today());
    }

    /**
     * Scope untuk appointment yang disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope untuk appointment yang dibatalkan
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope untuk appointment direschedule
     */
    public function scopeRescheduled($query)
    {
        return $query->where('status', self::STATUS_RESCHEDULED);
    }

    /**
     * Scope untuk appointment selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }
    
    /**
     * Scope untuk appointment yang akan datang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>=', Carbon::now());
    }
    
    /**
     * Scope untuk appointment berdasarkan bulan
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('scheduled_at', Carbon::now()->month);
    }

    // ====================
    // ACCESSORS & MUTATORS
    // ====================

    /**
     * Get appointment date (hanya tanggal)
     */
    public function getAppointmentDateAttribute()
    {
        return $this->scheduled_at ? $this->scheduled_at->format('Y-m-d') : null;
    }

    /**
     * Get appointment time (hanya waktu)
     */
    public function getAppointmentTimeAttribute()
    {
        return $this->scheduled_at ? $this->scheduled_at->format('H:i:s') : null;
    }

    /**
     * Get formatted date for display
     */
    public function getFormattedDateAttribute()
    {
        return $this->scheduled_at ? $this->scheduled_at->format('d M Y') : null;
    }

    /**
     * Get formatted time for display
     */
    public function getFormattedTimeAttribute()
    {
        return $this->scheduled_at ? $this->scheduled_at->format('h:i A') : null;
    }

    /**
     * Get full datetime for display
     */
    public function getFullDateTimeAttribute()
    {
        if (!$this->scheduled_at) return null;
        
        $date = $this->scheduled_at->format('d M Y');
        $time = $this->scheduled_at->format('h:i A');
        return "$date at $time";
    }

    /**
     * Get rescheduled date if exists
     */
    public function getRescheduledDateAttribute()
    {
        return $this->rescheduled_at ? $this->rescheduled_at->format('Y-m-d') : null;
    }

    /**
     * Get rescheduled time if exists
     */
    public function getRescheduledTimeAttribute()
    {
        return $this->rescheduled_at ? $this->rescheduled_at->format('H:i:s') : null;
    }
    
    /**
     * Get rescheduled formatted datetime
     */
    public function getRescheduledFormattedAttribute()
    {
        if (!$this->rescheduled_at) return null;
        
        $date = $this->rescheduled_at->format('d M Y');
        $time = $this->rescheduled_at->format('h:i A');
        return "$date at $time";
    }

    // ====================
    // STATUS CHECK METHODS
    // ====================

    /**
     * Check if appointment is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if appointment is approved
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if appointment is cancelled
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if appointment is rescheduled
     */
    public function isRescheduled()
    {
        return $this->status === self::STATUS_RESCHEDULED;
    }

    /**
     * Check if appointment is completed
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }
    
    /**
     * Check if appointment is upcoming (not passed)
     */
    public function isUpcoming()
    {
        return $this->scheduled_at && $this->scheduled_at->gt(Carbon::now());
    }
    
    /**
     * Check if appointment is passed
     */
    public function isPassed()
    {
        return $this->scheduled_at && $this->scheduled_at->lt(Carbon::now());
    }

    // ====================
    // ACTION METHODS
    // ====================

    /**
     * Approve appointment
     */
    public function approve($notes = null)
    {
        $this->status = self::STATUS_APPROVED;
        if ($notes) {
            $this->notes = $notes;
        }
        return $this->save();
    }

    /**
     * Cancel appointment
     */
    public function cancel($reason = null)
    {
        $this->status = self::STATUS_CANCELLED;
        if ($reason) {
            $this->reason = $reason;
        }
        return $this->save();
    }

    /**
     * Reschedule appointment
     */
    public function reschedule($newDateTime, $reason = null)
    {
        $this->status = self::STATUS_RESCHEDULED;
        $this->rescheduled_at = $newDateTime;
        if ($reason) {
            $this->reason = $reason;
        }
        return $this->save();
    }

    /**
     * Complete appointment
     */
    public function complete($notes = null)
    {
        $this->status = self::STATUS_COMPLETED;
        if ($notes) {
            $this->notes = $notes;
        }
        return $this->save();
    }
    
    /**
     * Mark as pending
     */
    public function markAsPending()
    {
        $this->status = self::STATUS_PENDING;
        return $this->save();
    }

    // ====================
    // UI HELPER METHODS
    // ====================

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'badge bg-warning';
            case self::STATUS_APPROVED:
                return 'badge bg-success';
            case self::STATUS_CANCELLED:
                return 'badge bg-danger';
            case self::STATUS_RESCHEDULED:
                return 'badge bg-info';
            case self::STATUS_COMPLETED:
                return 'badge bg-secondary';
            default:
                return 'badge bg-light';
        }
    }
    
    /**
     * Get status color for UI (Tailwind)
     */
    public function getStatusColor()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'bg-yellow-100 text-yellow-800';
            case self::STATUS_APPROVED:
                return 'bg-green-100 text-green-800';
            case self::STATUS_CANCELLED:
                return 'bg-red-100 text-red-800';
            case self::STATUS_RESCHEDULED:
                return 'bg-blue-100 text-blue-800';
            case self::STATUS_COMPLETED:
                return 'bg-gray-100 text-gray-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    /**
     * Get status icon for UI
     */
    public function getStatusIcon()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'fa-clock';
            case self::STATUS_APPROVED:
                return 'fa-check-circle';
            case self::STATUS_CANCELLED:
                return 'fa-times-circle';
            case self::STATUS_RESCHEDULED:
                return 'fa-calendar-alt';
            case self::STATUS_COMPLETED:
                return 'fa-check-double';
            default:
                return 'fa-question-circle';
        }
    }
    
    /**
     * Get status text for display
     */
    public function getStatusText()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'Menunggu Konfirmasi';
            case self::STATUS_APPROVED:
                return 'Disetujui';
            case self::STATUS_CANCELLED:
                return 'Dibatalkan';
            case self::STATUS_RESCHEDULED:
                return 'Dijadwalkan Ulang';
            case self::STATUS_COMPLETED:
                return 'Selesai';
            default:
                return 'Unknown';
        }
    }
    
    /**
     * Get patient initials for avatar
     */
    public function getPatientInitialsAttribute()
    {
        if (!$this->user) return 'NA';
        
        $name = $this->user->name;
        $initials = '';
        
        $words = explode(' ', $name);
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
            if (strlen($initials) >= 2) break;
        }
        
        return $initials ?: 'NA';
    }
    
    /**
     * Get doctor name
     */
    public function getDoctorNameAttribute()
    {
        if (!$this->doctor) return 'Unknown Doctor';
        
        return $this->doctor->full_name ?? $this->doctor->user->name ?? 'Unknown Doctor';
    }
    
    /**
     * Get patient name
     */
    public function getPatientNameAttribute()
    {
        if (!$this->user) return 'Unknown Patient';
        
        return $this->user->name;
    }
    
    /**
     * Get patient phone
     */
    public function getPatientPhoneAttribute()
    {
        if (!$this->user) return null;
        
        return $this->user->phone;
    }
    
    /**
     * Get patient email
     */
    public function getPatientEmailAttribute()
    {
        if (!$this->user) return null;
        
        return $this->user->email;
    }

    // ====================
    // BUSINESS LOGIC METHODS
    // ====================
    
    /**
     * Check if appointment can be cancelled
     */
    public function canBeCancelled()
    {
        return $this->isPending() || $this->isApproved();
    }
    
    /**
     * Check if appointment can be rescheduled
     */
    public function canBeRescheduled()
    {
        return $this->isPending() || $this->isApproved() || $this->isRescheduled();
    }
    
    /**
     * Check if appointment can be completed
     */
    public function canBeCompleted()
    {
        return $this->isApproved() && $this->isPassed();
    }
    
    /**
     * Get time until appointment
     */
    public function getTimeUntilAppointment()
    {
        if (!$this->scheduled_at || $this->isPassed()) {
            return null;
        }
        
        return $this->scheduled_at->diffForHumans();
    }
}