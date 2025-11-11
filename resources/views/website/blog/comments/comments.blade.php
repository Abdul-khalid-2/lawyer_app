@php
    $comments = $blogPost->approvedComments()->with(['user', 'replies' => function($query) {
        $query->approved()->with('user');
    }])->orderBy('created_at', 'desc')->get();
@endphp

<div class="comments-section mt-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h6 class="mb-0">
                <i class="fas fa-comments me-2"></i>
                Comments ({{ $blogPost->comments_count }})
            </h6>
        </div>
        
        <div class="card-body">
            <!-- Comment Form -->
            <div class="comment-form mb-5">
                <h5 class="mb-3">Leave a Comment</h5>
                
                @auth
                    <p class="text-muted">Commenting as <strong>{{ auth()->user()->name }}</strong></p>
                @endauth
                
                <form action="{{ route('website.blog.comments.store', $blogPost) }}" method="POST">
                    @csrf
                    
                    <!-- Parent ID for replies -->
                    <input type="hidden" name="parent_id" id="parent_id" value="">
                    
                    @guest
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endguest
                    
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment *</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" 
                                  id="comment" name="comment" rows="4" 
                                  placeholder="Write your comment here..." required>{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Submit Comment
                    </button>
                </form>
            </div>
            
            <!-- Comments List -->
            <div class="comments-list" style="height: 150vh; overflow: auto;">
                @if($comments->count() > 0)
                    <div class="comments-tree">
                        @foreach($comments as $comment)
                            @include('website.blog.comments.comment-item', ['comment' => $comment, 'depth' => 0])
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-comments fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No comments yet. Be the first to comment!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .comments-tree {
        position: relative;
    }
    
    .comment-item {
        border-left: 3px solid transparent;
        transition: border-color 0.3s ease;
    }
    
    .comment-item:hover {
        border-left-color: #667eea;
    }
    
    .comment-replies {
        margin-left: 2rem;
        padding-left: 1.5rem;
        border-left: 2px solid #e9ecef;
    }
    
    .reply-form {
        display: none;
        margin-top: 1rem;
    }
    
    .reply-form.active {
        display: block;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reply functionality
    const replyButtons = document.querySelectorAll('.reply-btn');
    
    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            document.getElementById('parent_id').value = commentId;
            
            // Scroll to comment form
            document.getElementById('comment').focus();
            document.querySelector('.comment-form').scrollIntoView({ 
                behavior: 'smooth' 
            });
        });
    });
    
    // Cancel reply
    document.querySelector('.cancel-reply')?.addEventListener('click', function() {
        document.getElementById('parent_id').value = '';
    });
});
</script>