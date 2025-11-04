<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'phone',
        'profile_image',
        'role',
        'is_active'
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
            'is_active' => 'boolean',
        ];
    }

    public function lawyer()
    {
        return $this->hasOne(Lawyer::class);
    }

    public function activities()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    public function isLawyer()
    {
        return $this->hasRole('lawyer') && $this->lawyer !== null;
    }

    public function isClient()
    {
        return $this->hasRole('client');
    }

    // Accessor for profile image URL
    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : asset('images/default-avatar.png');
    }
}
