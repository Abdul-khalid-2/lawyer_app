<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\BlogPost;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(StoreCommentRequest $request, BlogPost $blogPost)
    {
        try {
            $commentData = [
                'blog_post_id' => $blogPost->id,
                'comment' => $request->comment,
                'parent_id' => $request->parent_id,
                'status' => 'pending', // Moderate comments
            ];

            // Add user data if logged in
            if (Auth::check()) {
                $commentData['user_id'] = Auth::id();
            } else {
                $commentData['name'] = $request->name;
                $commentData['email'] = $request->email;
            }

            $comment = Comment::create($commentData);

            return back()->with('success', 'Comment submitted successfully. It will be visible after approval.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit comment. Please try again.');
        }
    }

    /**
     * Get replies for a comment (for AJAX loading)
     */
    public function getReplies(Comment $comment)
    {
        $replies = $comment->replies()
            ->approved()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($replies);
    }
}
