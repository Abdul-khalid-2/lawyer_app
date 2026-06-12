<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $lawyer = Auth::user()->lawyer;
        abort_unless($lawyer, 403);

        $reviews = Review::with('user')
            ->where('lawyer_id', $lawyer->id)
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $base = Review::where('lawyer_id', $lawyer->id);
        $counts = [
            'all' => (clone $base)->count(),
            'pending' => (clone $base)->where('status', 'pending')->count(),
            'approved' => (clone $base)->where('status', 'approved')->count(),
            'rejected' => (clone $base)->where('status', 'rejected')->count(),
        ];
        $avgRating = (clone $base)->where('status', 'approved')->avg('rating') ?? 0;

        return view('dashboard.reviews.index', compact('reviews', 'counts', 'avgRating'));
    }

    public function updateStatus(Request $request, Review $review)
    {
        $this->authorizeOwnership($review);

        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        $review->update(['status' => $request->status]);

        return back()->with('success', 'Review marked as ' . $request->status . '.');
    }

    public function toggleFeatured(Review $review)
    {
        $this->authorizeOwnership($review);

        $review->update(['is_featured' => ! $review->is_featured]);

        return back()->with('success', $review->is_featured ? 'Review featured on your profile.' : 'Review removed from featured.');
    }

    public function destroy(Review $review)
    {
        $this->authorizeOwnership($review);

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }

    private function authorizeOwnership(Review $review): void
    {
        abort_unless($review->lawyer_id === Auth::user()->lawyer?->id, 403);
    }
}
