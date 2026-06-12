<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Review;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;

class WebsiteHomeController extends Controller
{

    public function home()
    {
        // Show all verified lawyers on the landing page, with featured ones
        // surfaced first (and tagged in the card).
        $featuredLawyers = Lawyer::with(['user', 'specializations', 'reviews'])
            ->where('is_verified', 1)
            ->orderByDesc('is_featured')
            ->orderBy('years_of_experience', 'desc')
            ->limit(12)
            ->get();

        // Calculate stats
        $stats = [
            'lawyersCount' => Lawyer::where('is_verified', true)->where('is_featured', true)->count(),
            'clientsCount' => \App\Models\User::count(), // Assuming you have a User model for clients
            'casesCount' => \App\Models\Portfolio::count(),
            'citiesCount' => Lawyer::where('is_verified', true)->distinct('city')->count('city'),
            'specializationsCount' => Specialization::count(),
        ];

        // Get recent testimonials
        $testimonials = Review::with('lawyer')
            ->where('status', 'approved')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('website.home', compact('featuredLawyers', 'stats', 'testimonials'));
    }

    public function browse(Request $request)
    {
        $query = Lawyer::with(['specializations', 'reviews'])
            ->where('is_verified', true)
            ->where('is_featured', true);

        // Search filters
        if ($request->has('specialization') && $request->specialization) {
            $query->whereHas('specializations', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->specialization . '%');
            });
        }

        if ($request->has('location') && $request->location) {
            $query->where(function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                    ->orWhere('state', 'like', '%' . $request->location . '%');
            });
        }

        $lawyers = $query->orderBy('years_of_experience', 'desc')->paginate(12);
        $specializations = Specialization::all();

        return view('website.browse_lawyers', compact('lawyers', 'specializations'));
    }

    public function getSpecializations()
    {
        // return JSON response
        return response()->json(Specialization::select('id', 'name')->get());
    }



    public function howItWork()
    {
        $stats = [
            'lawyersCount' => Lawyer::where('is_verified', true)->where('is_featured', true)->count(),
            'clientsCount' => \App\Models\User::count(), // Assuming you have a User model for clients
            'casesCount' => \App\Models\Portfolio::count(),
            'citiesCount' => Lawyer::where('is_verified', true)->distinct('city')->count('city'),
            'specializationsCount' => Specialization::count(),
        ];
        return view('website.how_it_works', compact('stats'));
    }

    public function about()
    {
        $stats = [
            'lawyersCount' => Lawyer::where('is_verified', true)->count(),
            'clientsCount' => \App\Models\User::count(),
            'casesCount' => \App\Models\Portfolio::count(),
            'citiesCount' => Lawyer::where('is_verified', true)->distinct('city')->count('city'),
            'specializationsCount' => Specialization::count(),
        ];

        $specializations = Specialization::where('is_active', true)->take(8)->get();

        return view('website.about', compact('stats', 'specializations'));
    }
}
