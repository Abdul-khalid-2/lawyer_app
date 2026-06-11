<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'lawyer_id',
        'name',
        'designation',
        'email',
        'phone',
        'photo',
        'bio',
        'qualifications',
        'years_of_experience',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'years_of_experience' => 'integer',
        'order' => 'integer',
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
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function cases()
    {
        return $this->hasMany(LegalCase::class);
    }

    // Accessors
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-avatar.png');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
