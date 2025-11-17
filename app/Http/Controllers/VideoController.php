<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YoutubeVideo;
use Illuminate\Support\Facades\Auth;
use App\Rules\YoutubeLink;

class VideoController extends Controller
{
    public function index()
    {
        $lawyer = Auth::user()->lawyer;
        $videos = YoutubeVideo::where('lawyer_id', $lawyer->id)
            ->latest()
            ->paginate(10);

        return view('dashboard.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('dashboard.videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_topic' => 'required|string|max:255',
            'youtube_link' => ['required', 'string', new YoutubeLink],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $lawyer = Auth::user()->lawyer;

        // Extract video ID from the input
        $videoId = YoutubeLink::extractVideoId($request->youtube_link);

        if (!$videoId) {
            return back()->withErrors(['youtube_link' => 'Could not extract YouTube video ID from the provided input.'])->withInput();
        }

        YoutubeVideo::create([
            'lawyer_id' => $lawyer->id,
            'title' => $request->title,
            'video_topic' => $request->video_topic,
            'youtube_link' => $request->youtube_link,
            'youtube_video_id' => $videoId,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
            'is_featured' => $request->is_featured ?? false,
            'published_at' => now(),
        ]);

        return redirect()->route('videos.index')
            ->with('success', 'Video added successfully!');
    }

    public function edit(YoutubeVideo $video)
    {
        // Check if the video belongs to the authenticated lawyer
        if ($video->lawyer_id !== Auth::user()->lawyer->id) {
            abort(403);
        }

        return view('dashboard.videos.edit', compact('video'));
    }

    public function update(Request $request, YoutubeVideo $video)
    {
        // Check if the video belongs to the authenticated lawyer
        if ($video->lawyer_id !== Auth::user()->lawyer->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'video_topic' => 'required|string|max:255',
            'youtube_link' => ['required', 'string', new YoutubeLink],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'display_count' => 'integer|min:0',
        ]);

        // Extract video ID from the input
        $videoId = YoutubeLink::extractVideoId($request->youtube_link);

        if (!$videoId) {
            return back()->withErrors(['youtube_link' => 'Could not extract YouTube video ID from the provided input.'])->withInput();
        }

        $video->update([
            'title' => $request->title,
            'video_topic' => $request->video_topic,
            'youtube_link' => $request->youtube_link,
            'youtube_video_id' => $videoId,
            'description' => $request->description,
            'is_active' => $request->is_active ?? $video->is_active,
            'is_featured' => $request->is_featured ?? $video->is_featured,
            'display_count' => $request->display_count ?? $video->display_count,
        ]);

        return redirect()->route('videos.index')
            ->with('success', 'Video updated successfully!');
    }

    public function destroy(YoutubeVideo $video)
    {
        // Check if the video belongs to the authenticated lawyer
        if ($video->lawyer_id !== Auth::user()->lawyer->id) {
            abort(403);
        }

        $video->delete();

        return redirect()->route('videos.index')
            ->with('success', 'Video deleted successfully!');
    }
}
