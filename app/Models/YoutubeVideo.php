<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class YoutubeVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'lawyer_id',
        'title',
        'video_topic',
        'youtube_link',
        'youtube_video_id',
        'description',
        'display_count',
        'view_count',
        'total_view_time',
        'is_active',
        'is_featured',
        'thumbnail',
        'duration',
        'published_at'
    ];

    protected $casts = [
        'thumbnail' => 'array',
        'published_at' => 'datetime',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'total_view_time' => 'integer',
        'duration' => 'integer',
        'view_count' => 'integer',
        'display_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }

            // Extract YouTube video ID from link
            if ($model->youtube_link && empty($model->youtube_video_id)) {
                $model->youtube_video_id = $model->extractYoutubeId($model->youtube_link);
            }
        });

        static::updating(function ($model) {
            // Update YouTube video ID if link changes
            if ($model->isDirty('youtube_link')) {
                $model->youtube_video_id = $model->extractYoutubeId($model->youtube_link);
            }
        });
    }

    /**
     * Extract YouTube video ID from various URL formats
     */
    public function extractYoutubeId($url): ?string
    {
        $patterns = [
            // Embed format: https://www.youtube.com/embed/VIDEO_ID
            '/youtube\.com\/embed\/([^"&?\/\s]{11})/',

            // Standard format: https://www.youtube.com/watch?v=VIDEO_ID
            '/youtube\.com\/watch\?v=([^"&?\/\s]{11})/',

            // Short format: https://youtu.be/VIDEO_ID
            '/youtu\.be\/([^"&?\/\s]{11})/',

            // Mobile format: https://m.youtube.com/watch?v=VIDEO_ID
            '/m\.youtube\.com\/watch\?v=([^"&?\/\s]{11})/',
        ];

        foreach ($patterns as $pattern) {
            preg_match($pattern, $url, $matches);
            if (isset($matches[1])) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Get embed URL for the video
     */
    public function getEmbedUrlAttribute(): string
    {
        return $this->youtube_video_id
            ? "https://www.youtube.com/embed/{$this->youtube_video_id}"
            : '';
    }

    /**
     * Get watch URL for the video
     */
    public function getWatchUrlAttribute(): string
    {
        return $this->youtube_video_id
            ? "https://www.youtube.com/watch?v={$this->youtube_video_id}"
            : '';
    }

    /**
     * Get short URL for the video
     */
    public function getShortUrlAttribute(): string
    {
        return $this->youtube_video_id
            ? "https://youtu.be/{$this->youtube_video_id}"
            : '';
    }


    public function lawyer(): BelongsTo
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function blogPosts(): BelongsToMany
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_youtube_video')
            ->withPivot('order')
            ->withTimestamps();
    }

    public function views()
    {
        return $this->hasMany(VideoView::class);
    }



    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->youtube_video_id) {
            return "https://img.youtube.com/vi/{$this->youtube_video_id}/hqdefault.jpg";
        }

        return $this->thumbnail['url'] ?? null;
    }

    /**
     * Scope active videos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope featured videos
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope by lawyer
     */
    public function scopeByLawyer($query, $lawyerId)
    {
        return $query->where('lawyer_id', $lawyerId);
    }
}
