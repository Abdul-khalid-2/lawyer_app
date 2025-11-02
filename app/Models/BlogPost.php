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
        'structure', // Make sure this is in fillable
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
        'structure' => 'array',
        'tags' => 'array',
        'banner' => 'array',
        'image' => 'array',
        'rich_text' => 'array',
        'text_left_image_right' => 'array',
        'custom_html' => 'array',
        'canvas_elements' => 'array',
        'published_at' => 'datetime'
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
