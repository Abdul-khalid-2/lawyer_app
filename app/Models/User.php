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
        ];
    }

    public function lawyer()
    {
        return $this->hasOne(Lawyer::class);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    public function isLawyer()
    {
        return $this->hasRole('lawyer');
    }

    public function isClient()
    {
        return $this->hasRole('client');
    }
}
