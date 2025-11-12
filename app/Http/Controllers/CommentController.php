<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display comments for a specific blog post
     */
    public function comments($id)
    {
        $post = BlogPost::with(['lawyer.user', 'category'])->findOrFail($id);

        $comments = Comment::with(['user', 'replies.user'])
            ->where('blog_post_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $commentStats = $this->getCommentStats($id);

        return view('dashboard.comments.index', compact('post', 'comments', 'commentStats'));
    }

    /**
     * Show individual comment details
     */
    public function show(Comment $comment)
    {
        $comment->load(['user', 'blogPost', 'replies.user']);


        return view('dashboard.comments.show', compact('comment'));
    }

    /**
     * Update comment status
     */
    public function updateStatus(Request $request, Comment $comment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,spam'
        ]);

        $comment->update([
            'status' => $request->status,
            'moderated_at' => now(),
            'moderated_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment status updated successfully',
            'status' => $comment->status,
            'status_badge' => $this->getStatusBadge($comment->status)
        ]);
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        DB::transaction(function () use ($comment) {
            // Delete all replies first
            $comment->replies()->delete();
            // Delete the comment
            $comment->delete();
        });

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Comment deleted successfully');
    }

    /**
     * Get comment statistics for a post
     */
    private function getCommentStats($postId)
    {
        return Comment::where('blog_post_id', $postId)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = "spam" THEN 1 ELSE 0 END) as spam
            ')
            ->first();
    }

    /**
     * Get status badge HTML
     */
    private function getStatusBadge($status)
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-success">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            'spam' => '<span class="badge bg-secondary">Spam</span>'
        ];

        return $badges[$status] ?? $badges['pending'];
    }
}
