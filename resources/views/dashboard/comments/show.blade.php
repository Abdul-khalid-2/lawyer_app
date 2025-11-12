<div class="comment-details">
    <!-- Comment Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ $comment->user->profile_image ? asset('website/' . $comment->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                 alt="{{ $comment->user->name }}" 
                 class="rounded-circle me-3"
                 style="width: 50px; height: 50px; object-fit: cover;">
            <div>
                <h6 class="mb-1">{{ $comment->user->name }}</h6>
                <small class="text-muted">{{ $comment->user->email }}</small>
                <br>
                <small class="text-muted">Commented on: {{ $comment->created_at->format('M j, Y g:i A') }}</small>
            </div>
        </div>
        @php
            $statusColors = [
                'pending' => 'warning',
                'approved' => 'success',
                'rejected' => 'danger',
                'spam' => 'secondary'
            ];
        @endphp
        <span class="badge bg-{{ $statusColors[$comment->status] ?? 'secondary' }}">
            {{ ucfirst($comment->status) }}
        </span>
    </div>

    <!-- Post Information -->
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title">Post: {{ $comment->blogPost->title }}</h6> <!-- Changed post to blogPost -->
            <small class="text-muted">Category: {{ $comment->blogPost->category->name ?? 'Uncategorized' }}</small> <!-- Changed post to blogPost -->
        </div>
    </div>

    <!-- Comment Content -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">Comment Content</h6>
        </div>
        <div class="card-body">
            <div class="comment-content">
                {!! nl2br(e($comment->comment)) !!} <!-- Changed content to comment -->
            </div>
        </div>
    </div>

    <!-- Replies Section -->
    @if($comment->replies->count() > 0)
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Replies ({{ $comment->replies->count() }})</h6>
        </div>
        <div class="card-body">
            @foreach($comment->replies as $reply)
            <div class="reply-item border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center">
                        <img src="{{ $reply->user->profile_image ? asset('website/' . $reply->user->profile_image) : asset('website/images/default-avatar.png') }}"
                             alt="{{ $reply->user->name }}" 
                             class="rounded-circle me-2"
                             style="width: 32px; height: 32px; object-fit: cover;">
                        <div>
                            <small class="fw-bold">{{ $reply->user->name }}</small>
                            <br>
                            <small class="text-muted">{{ $reply->created_at->format('M j, Y g:i A') }}</small>
                        </div>
                    </div>
                    <span class="badge bg-{{ $statusColors[$reply->status] ?? 'secondary' }}">
                        {{ ucfirst($reply->status) }}
                    </span>
                </div>
                <div class="reply-content">
                    {!! nl2br(e($reply->comment)) !!} <!-- Changed content to comment -->
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>