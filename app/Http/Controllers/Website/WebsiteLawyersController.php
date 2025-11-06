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
            'reviews' => function ($query) {
                $query->where('status', 'approved')
                    ->with('user')
                    ->orderBy('created_at', 'desc');
            },
            'educations' => function ($query) {
                $query->orderBy('order', 'asc')
                    ->orderBy('graduation_year', 'desc');
            },
            'experiences' => function ($query) {
                $query->orderBy('order', 'asc')
                    ->orderBy('start_date', 'desc');
            },
            'portfolios' => function ($query) {
                $query->where('is_public', true)
                    ->orderBy('is_featured', 'desc')
                    ->orderBy('year', 'desc');
            },
            'blog_posts' => function ($query) {
                $query->where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(3);
            }
        ])
            ->where('uuid', $uuid)
            ->where('is_verified', true)
            ->firstOrFail();

        // Increment view count
        $lawyer->increment('view_count');

        // Track visitor
        $this->trackVisitor($lawyer);

        // Calculate average rating
        $averageRating = $lawyer->reviews->avg('rating') ?? 0;

        // Calculate success rate (you can modify this based on your business logic)
        $successRate = $this->calculateSuccessRate($lawyer);

        return view('website.lawyer_profile', compact('lawyer', 'averageRating', 'successRate'));
    }

    private function trackVisitor($lawyer)
    {
        // Only track if not the lawyer themselves
        if (auth()->check() && auth()->user()->lawyer && auth()->user()->lawyer->id === $lawyer->id) {
            return;
        }

        $lawyer->visitors()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'country' => $this->getCountryFromIP(request()->ip()),
            'city' => $this->getCityFromIP(request()->ip()),
            'referrer' => request()->header('referer'),
            'page_visited' => request()->url(),
            'time_spent' => 0, // You can update this with JavaScript tracking
        ]);
    }

    private function getCountryFromIP($ip)
    {
        // Implement IP to country conversion
        // You can use a service like ipapi.com or maxmind.com
        return null;
    }

    private function getCityFromIP($ip)
    {
        // Implement IP to city conversion
        return null;
    }

    private function calculateSuccessRate($lawyer)
    {
        // Calculate success rate based on portfolio cases with positive outcomes
        $totalCases = $lawyer->portfolios->count();
        if ($totalCases === 0) {
            return 0;
        }

        $successfulCases = $lawyer->portfolios->filter(function ($portfolio) {
            return $this->isSuccessfulOutcome($portfolio->outcome);
        })->count();

        return round(($successfulCases / $totalCases) * 100);
    }

    private function isSuccessfulOutcome($outcome)
    {
        // Define what constitutes a successful outcome
        $successfulOutcomes = ['won', 'settled', 'dismissed', 'favorable', 'successful'];
        return in_array(strtolower($outcome), $successfulOutcomes);
    }


    public function trackTime($uuid, Request $request)
    {
        $lawyer = Lawyer::where('uuid', $uuid)->firstOrFail();

        // Update the latest visitor record for this IP
        $visitor = $lawyer->visitors()
            ->where('ip_address', $request->ip())
            ->latest()
            ->first();

        if ($visitor) {
            $visitor->update([
                'time_spent' => $request->time_spent
            ]);
        }

        return response()->json(['success' => true]);
    }
}
