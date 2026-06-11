<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'lawyer_id',
        'title',
        'type',
        'start_datetime',
        'end_datetime',
        'location',
        'case_id',
        'is_public',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_public' => 'boolean',
    ];

    public const TYPES = ['hearing', 'meeting', 'consultation', 'personal'];

    // Relationships
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>=', now())->orderBy('start_datetime');
    }

    // Accessors — color coding by type (used by calendar)
    public function getColorAttribute()
    {
        return match ($this->type) {
            'hearing' => '#dc3545',
            'meeting' => '#0d6efd',
            'consultation' => '#198754',
            'personal' => '#6c757d',
            default => '#0d6efd',
        };
    }
}
