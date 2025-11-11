<div class="comment-item mb-4 p-3 bg-light rounded" id="comment-{{ $comment->id }}">
    <div class="d-flex">
        <!-- Avatar -->
        <div class="flex-shrink-0 me-3">
            @if($comment->user && $comment->user->profile_image)
                <img src="{{ asset('website/' . $comment->user->profile_image) }}" 
                     alt="{{ $comment->getAuthorName() }}" 
                     class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
            @else
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px;">
                    <i class="fas fa-user"></i>
                </div>
            @endif
        </div>
        
        <!-- Comment Content -->
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h6 class="mb-1 fw-bold">{{ $comment->getAuthorName() }}</h6>
                    <small class="text-muted">
                        <i class="far fa-clock me-1"></i>
                        {{ $comment->created_at->diffForHumans() }}
                    </small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary reply-btn" 
                        data-comment-id="{{ $comment->id }}">
                    <i class="fas fa-reply me-1"></i>Reply
                </button>
            </div>
            
            <p class="mb-2">{{ $comment->comment }}</p>
        </div>
    </div>
    <!-- Replies -->
    @if($comment->hasReplies())
        <div class="comment-replies mt-3">
            @foreach($comment->replies as $reply)
                @include('website.blog.comments.comment-item', ['comment' => $reply, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div>

<style>
    .comment-replies {
        margin-left: 2rem;
        padding-left: 1.5rem;
        border-left: 2px solid #e9ecef;
    }
    
    /* Different background colors for different depths */
    .comment-item .comment-item .comment-item {
        background-color: #f8f9fa !important;
    }
    
    .comment-item .comment-item .comment-item .comment-item {
        background-color: #ffffff !important;
    }
</style>