<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\BlogPost;
use App\Models\Review;
use App\Models\Visitor;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'total_blog_posts' => BlogPost::count(),
            'total_reviews' => Review::count(),
            'total_visitors' => Visitor::count(),
        ];

        $recentActivities = UserActivity::with('user')
            ->latest()
            ->take(10)
            ->get();

        $popularLawyers = Lawyer::withCount('visitors')
            ->orderBy('visitors_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.dashboard', compact('stats', 'recentActivities', 'popularLawyers'));
    }

    private function lawyerDashboard($lawyer)
    {
        $stats = [
            'total_blog_posts' => $lawyer->blogPosts()->count(),
            'total_reviews' => $lawyer->reviews()->count(),
            'total_visitors' => $lawyer->visitors()->count(),
            'average_rating' => $lawyer->reviews()->avg('rating') ?? 0,
        ];

        $recentVisitors = $lawyer->visitors()
            ->latest()
            ->take(10)
            ->get();

        $recentReviews = $lawyer->reviews()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Time spent analytics (last 30 days)
        $timeSpentData = $lawyer->visitors()
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(time_spent) as total_time'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard.lawyers.dashboard', compact('stats', 'recentVisitors', 'recentReviews', 'timeSpentData', 'lawyer'));
    }
}
