<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lawyer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'uuid',
        'bar_number',
        'license_state',
        'bio',
        'years_of_experience',
        'firm_name',
        'website',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'hourly_rate',
        'services',
        'awards',
        'is_verified',
        'is_featured',
        'view_count',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'hourly_rate' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'lawyer_specialization')
            ->withPivot('years_of_experience')
            ->withTimestamps();
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function blog_posts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->user->profile_image ? asset('storage/' . $this->user->profile_image) : asset('images/default-avatar.png');
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('status', 'approved')->avg('rating') ?? 0;
    }

    public function getTotalBlogPostsAttribute()
    {
        return $this->blog_posts()->count();
    }

    public function getPublishedPostsAttribute()
    {
        return $this->blog_posts()->where('status', 'published')->count();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('is_active', true);
        });
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
