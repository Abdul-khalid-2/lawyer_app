<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LegalCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'lawyer_id',
        'client_id',
        'team_member_id',
        'case_number',
        'title',
        'type',
        'court_name',
        'judge_name',
        'description',
        'status',
        'filed_date',
        'next_hearing_date',
        'is_visible_to_client',
    ];

    protected $casts = [
        'filed_date' => 'date',
        'next_hearing_date' => 'date',
        'is_visible_to_client' => 'boolean',
    ];

    public const TYPES = ['civil', 'criminal', 'family', 'corporate', 'tax'];
    public const STATUSES = ['pending', 'active', 'on_hold', 'won', 'lost', 'closed'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // Relationships
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function documents()
    {
        return $this->hasMany(CaseDocument::class, 'case_id');
    }

    public function notes()
    {
        return $this->hasMany(CaseNote::class, 'case_id');
    }

    public function hearings()
    {
        return $this->hasMany(CaseHearing::class, 'case_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'case_id');
    }

    // Scopes
    public function scopeVisibleToClient($query)
    {
        return $query->where('is_visible_to_client', true);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'active' => 'primary',
            'on_hold' => 'secondary',
            'won' => 'success',
            'lost' => 'danger',
            'closed' => 'dark',
            default => 'secondary',
        };
    }
}
