<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'lawyer_id',
        'position',
        'company',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'order'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    // Relationships
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    // Accessors
    public function getDurationAttribute()
    {
        $start = $this->start_date;
        $end = $this->is_current ? now() : $this->end_date;

        $years = $start->diffInYears($end);
        $months = $start->diffInMonths($end) % 12;

        if ($years > 0 && $months > 0) {
            return "{$years}y {$months}m";
        } elseif ($years > 0) {
            return "{$years}y";
        } else {
            return "{$months}m";
        }
    }

    public function getFormattedDateAttribute()
    {
        $start = $this->start_date->format('M Y');
        $end = $this->is_current ? 'Present' : $this->end_date->format('M Y');

        return "{$start} - {$end}";
    }
}
