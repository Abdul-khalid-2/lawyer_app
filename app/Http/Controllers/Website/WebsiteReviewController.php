<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsiteReviewController extends Controller
{
    public function store(Request $request, $lawyerUuid)
    {
        $lawyer = Lawyer::where('uuid', $lawyerUuid)->firstOrFail();

        // Check if user can review
        if (auth()->user()->id === $lawyer->user_id) {
            return redirect()->back()->with('error', 'You cannot review your own profile.');
        }

        if (auth()->user()->hasRole('lawyer')) {
            return redirect()->back()->with('error', 'Lawyers cannot review other lawyers.');
        }

        // Check if user has already reviewed
        $existingReview = Review::where('lawyer_id', $lawyer->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this lawyer.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'review' => 'required|string|min:10|max:500',
        ]);

        try {
            DB::transaction(function () use ($validated, $lawyer) {
                Review::create([
                    'uuid' => \Str::uuid(),
                    'lawyer_id' => $lawyer->id,
                    'user_id' => auth()->id(),
                    'rating' => $validated['rating'],
                    'title' => $validated['title'],
                    'review' => $validated['review'],
                    'status' => 'pending', // Reviews need approval
                    'is_featured' => false,
                ]);
            });

            return redirect()->back()->with('success', 'Thank you for your review! It will be visible after approval.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit review. Please try again.');
        }
    }

    public function updateStatus(Request $request, $reviewUuid)
    {
        $review = Review::where('uuid', $reviewUuid)->firstOrFail();

        // Authorization check - only super admin or lawyer owner
        if (!auth()->user()->hasRole('super_admin') && auth()->user()->id !== $review->lawyer->user_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $review->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Review status updated successfully.');
    }

    public function toggleFeatured(Request $request, $reviewUuid)
    {
        $review = Review::where('uuid', $reviewUuid)->firstOrFail();

        // Only super admin can feature reviews
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403);
        }

        $review->update(['is_featured' => !$review->is_featured]);

        $message = $review->is_featured ? 'Review featured successfully.' : 'Review unfeatured successfully.';

        return redirect()->back()->with('success', $message);
    }

    public function destroy($reviewUuid)
    {
        $review = Review::where('uuid', $reviewUuid)->firstOrFail();

        // Only super admin can delete reviews
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
