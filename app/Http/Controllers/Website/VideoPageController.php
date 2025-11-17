<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class VideoPageController extends Controller
{
    public function index(Request $request)
    {
        $query = YoutubeVideo::with(['lawyer.user'])
            ->active()
            ->latest();

        // Filter by topic if provided
        if ($request->has('topic') && $request->topic) {
            $query->where('video_topic', 'like', '%' . $request->topic . '%');
        }

        // Filter by lawyer if provided
        if ($request->has('lawyer') && $request->lawyer) {
            $query->whereHas('lawyer', function ($q) use ($request) {
                $q->where('uuid', $request->lawyer);
            });
        }

        $videos = $query->paginate(12);
        $topics = YoutubeVideo::active()->distinct()->pluck('video_topic');
        $featuredVideos = YoutubeVideo::with(['lawyer.user'])
            ->active()
            ->featured()
            ->orderBy('display_count', 'desc')
            ->limit(6)
            ->get();

        return view('website.videos.index', compact('videos', 'topics', 'featuredVideos'));
    }

    public function show($uuid)
    {
        $video = YoutubeVideo::with(['lawyer.user', 'lawyer.specializations'])
            ->active()
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Increment view count
        $video->increment('view_count');

        // Get related videos
        $relatedVideos = YoutubeVideo::with(['lawyer.user'])
            ->active()
            ->where('video_topic', $video->video_topic)
            ->where('id', '!=', $video->id)
            ->limit(4)
            ->get();

        return view('website.videos.show', compact('video', 'relatedVideos'));
    }

    public function trackViewTime(Request $request, $uuid)
    {
        $request->validate([
            'watch_time' => 'required|integer|min:0',
            'completed' => 'boolean',
        ]);

        $video = YoutubeVideo::where('uuid', $uuid)->firstOrFail();

        // Create or update view record
        $view = $video->views()->updateOrCreate(
            [
                'ip_address' => $request->ip(),
                'user_id' => auth()->id(),
            ],
            [
                'watch_time' => $request->watch_time,
                'completed' => $request->completed ?? false,
                'user_agent' => $request->userAgent(),
            ]
        );

        // Update total view time
        $video->total_view_time = $video->views()->sum('watch_time');
        $video->save();

        return response()->json(['success' => true]);
    }
}
