<!-- Reviews Section -->
<div class="profile-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="section-title mb-0">Client Reviews</h3>
        <span class="badge bg-primary">{{ $lawyer->reviews->count() }} reviews</span>
    </div>

    <!-- Review Form for Logged-in Users -->
    @auth
        @if(auth()->user()->id !== $lawyer->user_id && !auth()->user()->hasRole('lawyer'))
            @php
                $userHasReviewed = $lawyer->reviews->where('user_id', auth()->id())->count() > 0;
            @endphp

            @if(!$userHasReviewed)
            <div class="review-form-card mb-4">
                <h5 class="mb-3">Write a Review</h5>
                <form action="{{ route('website.reviews.store', $lawyer->uuid) }}" method="POST" id="reviewForm">
                    @csrf

                    <!-- Rating Input -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Your Rating *</label>
                        <div class="rating-input">
                            @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label for="star{{ $i }}" class="star-rating">
                                <i class="far fa-star"></i>
                                <i class="fas fa-star"></i>
                            </label>
                            @endfor
                        </div>
                        @error('rating')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="rating-labels mt-1">
                            <small class="text-muted">
                                <span id="ratingText">Select your rating</span>
                            </small>
                        </div>
                    </div>

                    <!-- Review Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Review Title (Optional)</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title') }}"
                            placeholder="Summarize your experience">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Review Content -->
                    <div class="mb-3">
                        <label for="review" class="form-label fw-bold">Your Review *</label>
                        <textarea class="form-control @error('review') is-invalid @enderror"
                                id="review" name="review" rows="4"
                                placeholder="Share your experience with this lawyer..."
                                required>{{ old('review') }}</textarea>
                        @error('review')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <span id="charCount">0</span>/500 characters
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Your review will be publicly visible after approval.
                        </small>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Submit Review
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>You have already reviewed this lawyer.</span>
                </div>
            </div>
            @endif
        @elseif(auth()->user()->id === $lawyer->user_id)
        <div class="alert alert-secondary mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-user me-2"></i>
                <span>You cannot review your own profile.</span>
            </div>
        </div>
        @elseif(auth()->user()->hasRole('lawyer'))
        <div class="alert alert-secondary mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-gavel me-2"></i>
                <span>Lawyers cannot review other lawyers.</span>
            </div>
        </div>
        @endif
    @else
    <div class="alert alert-warning mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <i class="fas fa-exclamation-circle me-2"></i>
                <span>Please <a  class="primary me-2" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</a> to leave a review.</span>
            </div>
            <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary">Sign Up</a>
        </div>
    </div>
    @endauth

    <!-- Reviews List -->
    @forelse($lawyer->reviews as $review)
        <x-website.cards.review-card :review="$review" :lawyer="$lawyer" />
    @empty
    <div class="text-center py-4">
        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
        <p class="text-muted">No reviews yet. Be the first to review this lawyer!</p>
    </div>
    @endforelse

    <!-- Reviews Pagination -->
    @if($lawyer->reviews->count() > 5)
    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    @endif
</div>
