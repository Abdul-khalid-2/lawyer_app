<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\YoutubeVideo;
use App\Models\Lawyer;
use Illuminate\Http\Request;

class VideoPageController extends Controller
{
    public function index(Request $request)
    {
        $query = YoutubeVideo::with(['lawyer.user'])
            ->active()
            ->whereHas('lawyer', function ($q) {
                $q->where('is_verified', true);
            });

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

        // Sort videos
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'featured':
                $query->featured()->orderBy('display_count', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $videos = $query->paginate(12);

        // Get unique topics for filter
        $topics = YoutubeVideo::active()
            ->whereHas('lawyer', function ($q) {
                $q->where('is_verified', true);
            })
            ->distinct()
            ->pluck('video_topic')
            ->filter();

        // Get featured videos
        $featuredVideos = YoutubeVideo::with(['lawyer.user'])
            ->active()
            ->featured()
            ->whereHas('lawyer', function ($q) {
                $q->where('is_verified', true);
            })
            ->orderBy('display_count', 'desc')
            ->limit(6)
            ->get();

        // Get popular lawyers with videos
        $popularLawyers = Lawyer::with(['user', 'specializations'])
            ->where('is_verified', true)
            ->whereHas('youtubeVideos', function ($q) {
                $q->active();
            })
            ->withCount(['youtubeVideos' => function ($q) {
                $q->active();
            }])
            ->orderBy('youtube_videos_count', 'desc')
            ->limit(10)
            ->get();

        return view('website.videos.index', compact('videos', 'topics', 'featuredVideos', 'popularLawyers', 'sort'));
    }

    public function show($uuid)
    {
        $video = YoutubeVideo::with([
            'lawyer.user',
            'lawyer.specializations',
            'lawyer.educations',
            'lawyer.experiences'
        ])
            ->active()
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Check if lawyer is verified
        if (!$video->lawyer->is_verified) {
            abort(404);
        }

        // Increment view count
        $video->increment('view_count');

        // Get related videos
        $relatedVideos = YoutubeVideo::with(['lawyer.user'])
            ->active()
            ->where('video_topic', $video->video_topic)
            ->where('id', '!=', $video->id)
            ->whereHas('lawyer', function ($q) {
                $q->where('is_verified', true);
            })
            ->limit(4)
            ->get();

        // If no related videos by topic, get latest videos from same lawyer
        if ($relatedVideos->isEmpty()) {
            $relatedVideos = YoutubeVideo::with(['lawyer.user'])
                ->active()
                ->where('lawyer_id', $video->lawyer_id)
                ->where('id', '!=', $video->id)
                ->limit(4)
                ->get();
        }

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
