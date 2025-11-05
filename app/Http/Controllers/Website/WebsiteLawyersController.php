<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Specialization;
use Illuminate\Http\Request;

class WebsiteLawyersController extends Controller
{
    public function index(Request $request)
    {
        // Get all specializations for the filter dropdown
        $specializations = Specialization::where('is_active', true)->get();

        // Get initial lawyers (first 10)
        $lawyers = $this->getLawyersQuery($request)->limit(10)->get();

        return view('website.lawyers', compact('lawyers', 'specializations'));
    }

    public function loadMore(Request $request)
    {
        $skip = $request->input('skip', 0);
        $lawyers = $this->getLawyersQuery($request)
            ->skip($skip)
            ->limit(10)
            ->get();

        $hasMore = $lawyers->count() >= 10;
        $nextSkip = $skip + 10;

        $html = view('website.lawyers_card', compact('lawyers'))->render();

        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore,
            'nextSkip' => $nextSkip
        ]);
    }

    private function getLawyersQuery(Request $request)
    {
        $query = Lawyer::with([
            'user',
            'specializations',
            'reviews' => function ($q) {
                $q->where('status', 'approved');
            },
            'educations',
            'experiences'
        ])
            ->where('is_verified', true)
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            });

        // Apply specialization filter
        if ($request->filled('specialization')) {
            $query->whereHas('specializations', function ($q) use ($request) {
                $q->where('uuid', $request->specialization);
            });
        }

        // Apply location filter
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function ($q) use ($location) {
                $q->where('city', 'like', "%{$location}%")
                    ->orWhere('state', 'like', "%{$location}%")
                    ->orWhere('country', 'like', "%{$location}%");
            });
        }

        return $query->orderBy('is_featured', 'desc')
            ->orderBy('years_of_experience', 'desc')
            ->orderBy('created_at', 'desc');
    }


    public function show($uuid)
    {
        $lawyer = Lawyer::with([
            'user',
            'specializations',
            'reviews' => function ($q) {
                $q->where('status', 'approved')->with('user');
            },
            'educations',
            'experiences',
            'portfolios'
        ])
            ->where('uuid', $uuid)
            ->where('is_verified', true)
            ->firstOrFail();

        // Increment view count
        $lawyer->increment('view_count');

        return view('website.lawyer_profile', compact('lawyer'));
    }
}
