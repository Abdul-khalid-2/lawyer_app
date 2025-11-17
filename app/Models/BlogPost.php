<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'lawyer_id',
        'blog_category_id',
        'heading',
        'title',
        'slug',
        'structure',
        'excerpt',
        'content',
        'featured_image',
        'tags',
        'view_count',
        'read_time',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'banner',
        'image',
        'rich_text',
        'text_left_image_right',
        'custom_html',
        'canvas_elements'
    ];

    protected $casts = [
        'tags' => 'array',
        'heading' => 'array',
        'published_at' => 'datetime',
        'structure' => 'array',
        'banner' => 'array',
        'image' => 'array',
        'rich_text' => 'array',
        'text_left_image_right' => 'array',
        'custom_html' => 'array',
        'canvas_elements' => 'array'
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    /**
     * Get all comments with replies for the blog post.
     */
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get approved comments for the blog post.
     */
    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->approved()->whereNull('parent_id');
    }

    /**
     * Get comments count.
     */
    public function getCommentsCountAttribute()
    {
        return $this->allComments()->approved()->count();
    }

    public function youtubeVideos(): BelongsToMany
    {
        return $this->belongsToMany(YoutubeVideo::class, 'blog_post_youtube_video')
            ->withPivot('order')
            ->withTimestamps()
            ->orderBy('order');
    }
}
