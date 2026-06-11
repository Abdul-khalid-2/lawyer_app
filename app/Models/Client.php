<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'lawyer_id',
        'phone',
        'cnic',
        'address',
        'city',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function cases()
    {
        return $this->hasMany(LegalCase::class);
    }

    // Accessors
    public function getNameAttribute()
    {
        return $this->user?->name;
    }

    public function getEmailAttribute()
    {
        return $this->user?->email;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
