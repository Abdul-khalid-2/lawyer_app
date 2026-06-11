<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseHearing extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'hearing_date',
        'hearing_time',
        'court_name',
        'room',
        'purpose',
        'outcome',
        'status',
    ];

    protected $casts = [
        'hearing_date' => 'date',
    ];

    public const STATUSES = ['scheduled', 'completed', 'adjourned', 'cancelled'];

    // Relationships
    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')
            ->whereDate('hearing_date', '>=', now()->toDateString())
            ->orderBy('hearing_date');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'scheduled' => 'primary',
            'completed' => 'success',
            'adjourned' => 'warning',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
