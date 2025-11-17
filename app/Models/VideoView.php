<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    use HasFactory;

    protected $fillable = [
        'youtube_video_id',
        'user_id',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'watch_time',
        'completed'
    ];

    protected $casts = [
        'watch_time' => 'integer',
        'completed' => 'boolean',
    ];

    public function video()
    {
        return $this->belongsTo(YoutubeVideo::class, 'youtube_video_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
