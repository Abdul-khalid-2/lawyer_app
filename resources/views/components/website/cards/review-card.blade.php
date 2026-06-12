@props(['review', 'lawyer'])
<div class="review-card">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <div>
            <h6 class="mb-1 fw-bold">
                {{ $review->user->name ?? 'Anonymous Client' }}
                @if($review->user && $review->user->hasRole('client'))
                    <small class="text-muted">• Verified Client</small>
                @endif
            </h6>
            <p class="text-muted mb-0 small">{{ $review->created_at->format('F j, Y') }}</p>
        </div>
        <x-website.ui.rating :value="$review->rating" :show-value="false" />
    </div>

    @if($review->title)
        <h6 class="text-primary mb-2">{{ $review->title }}</h6>
    @endif

    <p class="mb-0">{{ $review->review }}</p>

    @if($review->is_featured)
        <div class="mt-2">
            <x-website.ui.badge variant="featured" icon="fas fa-star">Featured Review</x-website.ui.badge>
        </div>
    @endif

    @auth
        <!-- @if(auth()->user()->hasRole('super_admin') || auth()->user()->id === $lawyer->user_id)
            <div class="mt-3 pt-2 border-top">
                <div class="btn-group btn-group-sm">
                    @if(auth()->user()->hasRole('super_admin'))
                        <form action="{{ route('website.reviews.update-status', $review->uuid) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $review->status === 'approved' ? 'pending' : 'approved' }}">
                            <button type="submit" class="btn btn-sm {{ $review->status === 'approved' ? 'btn-warning' : 'btn-success' }}">
                                {{ $review->status === 'approved' ? 'Unapprove' : 'Approve' }}
                            </button>
                        </form>

                        <form action="{{ route('website.reviews.toggle-featured', $review->uuid) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $review->is_featured ? 'btn-secondary' : 'btn-warning' }}">
                                {{ $review->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </form>

                        <form action="{{ route('website.reviews.destroy', $review->uuid) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this review?')">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>

                @if($review->status !== 'approved')
                    <span class="badge bg-secondary ms-2">{{ ucfirst($review->status) }}</span>
                @endif
            </div>
        @endif -->
    @endauth
</div>
