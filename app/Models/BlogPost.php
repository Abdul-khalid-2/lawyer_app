<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'lawyer_id',
        'blog_category_id',
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
        'published_at' => 'datetime',
        'structure' => 'array',
        'banner' => 'array',
        'image' => 'array',
        'rich_text' => 'array',
        'text_left_image_right' => 'array',
        'custom_html' => 'array',
        'canvas_elements' => 'array'
    ];

    // Add this accessor to safely handle tags
    public function getTagsAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        return $value ?? [];
    }

    // Relationships
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
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeWithTag($query, $tag)
    {
        return $query->where('tags', 'like', '%"' . $tag . '"%');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }
}
