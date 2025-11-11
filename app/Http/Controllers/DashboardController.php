<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\BlogPost;
use App\Models\Review;
use App\Models\Visitor;
use App\Models\UserActivity;
use App\Models\Specialization;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Portfolio;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        } elseif ($user->isLawyer()) {
            return $this->lawyerDashboard($user->lawyer);
        }

        return redirect('/');
    }

    private function superAdminDashboard()
    {
        $stats = [
            'total_lawyers' => Lawyer::count(),
            'verified_lawyers' => Lawyer::where('is_verified', true)->count(),
            'featured_lawyers' => Lawyer::where('is_featured', true)->count(),
            'total_blog_posts' => BlogPost::count(),
            'published_posts' => BlogPost::where('status', 'published')->count(),
            'total_reviews' => Review::count(),
            'approved_reviews' => Review::where('status', 'approved')->count(),
            'total_visitors' => Visitor::count(),
            'active_specializations' => Specialization::where('is_active', true)->count(),
        ];

        // Recent activities across all users
        $recentActivities = UserActivity::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Popular lawyers based on view count and reviews
        $popularLawyers = Lawyer::withCount(['visitors', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        // Recent blog posts
        $recentBlogPosts = BlogPost::with(['lawyer.user', 'category'])
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        // Visitor growth (last 30 days)
        $visitorGrowth = Visitor::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard.super_admin', compact(
            'stats',
            'recentActivities',
            'popularLawyers',
            'recentBlogPosts',
            'visitorGrowth'
        ));
    }

    private function lawyerDashboard($lawyer)
    {
        // Basic statistics
        $stats = [
            'total_blog_posts' => $lawyer->blog_posts()->count(),
            'published_posts' => $lawyer->blog_posts()->where('status', 'published')->count(),
            'total_reviews' => $lawyer->reviews()->count(),
            'approved_reviews' => $lawyer->reviews()->where('status', 'approved')->count(),
            'total_visitors' => $lawyer->visitors()->count(),
            'average_rating' => $lawyer->reviews()->where('status', 'approved')->avg('rating') ?? 0,
            'profile_views' => $lawyer->view_count,
            'specializations_count' => $lawyer->specializations()->count(),
            'educations_count' => $lawyer->educations()->count(),
            'experiences_count' => $lawyer->experiences()->count(),
            'portfolios_count' => $lawyer->portfolios()->where('is_public', true)->count(),
        ];

        // Recent visitors with detailed information
        $recentVisitors = $lawyer->visitors()
            ->latest()
            ->take(10)
            ->get();

        $recentReviews = $lawyer->reviews()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent blog posts
        $recentBlogPosts = $lawyer->blog_posts()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        // Time spent analytics (last 30 days)
        $timeSpentData = $lawyer->visitors()
            ->where('created_at', '>=', now()->subDays(30))
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(time_spent) as total_time'),
                DB::raw('COUNT(*) as visitor_count'),
                DB::raw('AVG(time_spent) as avg_time')
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Visitor chart data for the last 30 days
        $visitorChartData = $this->getVisitorChartData($lawyer);

        // Specialization distribution
        $specializationData = $this->getSpecializationData($lawyer);

        // Profile completion percentage
        $profileCompletion = $this->calculateProfileCompletion($lawyer);

        // Recent user activities
        $recentActivities = $lawyer->user->activities()
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.lawyers.dashboard', compact(
            'stats',
            'recentVisitors',
            'recentReviews',
            'recentBlogPosts',
            'timeSpentData',
            'visitorChartData',
            'specializationData',
            'profileCompletion',
            'recentActivities',
            'lawyer'
        ));
    }

    private function getVisitorChartData($lawyer)
    {
        $visitors = $lawyer->visitors()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $data = [];

        // Generate last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M j');

            $visitorCount = $visitors->firstWhere('date', $date);
            $data[] = $visitorCount ? $visitorCount->count : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }


    private function getSpecializationData($lawyer)
    {
        $specializations = $lawyer->specializations()
            ->withPivot('years_of_experience')
            ->get();

        return $specializations->map(function ($specialization) {
            return [
                'name' => $specialization->name,
                'icon' => $specialization->icon,
                'years_experience' => $specialization->pivot->years_of_experience ?? 0,
            ];
        });
    }

    private function calculateProfileCompletion($lawyer)
    {
        $completionItems = [
            'bio' => !empty(trim($lawyer->bio)),
            'profile_image' => !empty($lawyer->user->profile_image),
            'specializations' => $lawyer->specializations()->count() > 0,
            'educations' => $lawyer->educations()->count() > 0,
            'experiences' => $lawyer->experiences()->count() > 0,
            'portfolios' => $lawyer->portfolios()->count() > 0,
            'contact_info' => !empty($lawyer->phone) && !empty($lawyer->address),
            'bar_number' => !empty($lawyer->bar_number),
        ];

        $completed = count(array_filter($completionItems));
        $total = count($completionItems);

        return round(($completed / $total) * 100);
    }

    // Additional helper methods for more detailed analytics

    public function getMonthlyStats($lawyer)
    {
        $currentMonth = now()->month;
        $previousMonth = now()->subMonth()->month;

        return [
            'current_month_visitors' => $lawyer->visitors()
                ->whereMonth('created_at', $currentMonth)
                ->count(),
            'previous_month_visitors' => $lawyer->visitors()
                ->whereMonth('created_at', $previousMonth)
                ->count(),
            'current_month_posts' => $lawyer->blog_posts()
                ->whereMonth('created_at', $currentMonth)
                ->count(),
            'current_month_reviews' => $lawyer->reviews()
                ->whereMonth('created_at', $currentMonth)
                ->count(),
        ];
    }

    public function getTopPerformingContent($lawyer)
    {
        return $lawyer->blog_posts()
            ->where('status', 'published')
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get(['id', 'title', 'view_count', 'created_at']);
    }

    public function getGeographicData($lawyer)
    {
        return $lawyer->visitors()
            ->select('country', 'city', DB::raw('COUNT(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country', 'city')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();
    }
}
