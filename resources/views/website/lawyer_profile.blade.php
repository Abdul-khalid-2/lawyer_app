@extends('website.layout.master')

@push('css')
<link rel="stylesheet" href="{{ asset('website/css/profile.css') }}">
<style>
    .specialization-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        margin: 0.25rem;
        display: inline-block;
    }
    
    .verified-badge {
        background: #28a745;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        margin-left: 1rem;
    }
    
    .profile-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .section-title {
        color: #2c3e50;
        border-bottom: 3px solid #3498db;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .profile-image {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #f8f9fa;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .contact-widget {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .stats-box {
        text-align: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .stats-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
    }
    
    .timeline-item {
        border-left: 3px solid #3498db;
        padding-left: 1.5rem;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 0;
        width: 13px;
        height: 13px;
        background: #3498db;
        border-radius: 50%;
    }
    
    .review-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #3498db;
    }
    
    .rating {
        color: #ffc107;
    }
</style>
@endpush
@push('css')
<style>
    .review-form-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 2rem;
        border-left: 4px solid #3498db;
    }

    .rating-input {
        direction: rtl;
        unicode-bidi: bidi-override;
        display: inline-block;
    }

    .rating-input input[type="radio"] {
        display: none;
    }

    .rating-input label.star-rating {
        position: relative;
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        margin: 0 2px;
        transition: color 0.2s ease;
    }

    .rating-input label.star-rating .fas {
        display: none;
    }

    .rating-input label.star-rating .far {
        display: inline;
    }

    .rating-input input[type="radio"]:checked ~ label.star-rating .far,
    .rating-input label.star-rating:hover .far,
    .rating-input label.star-rating:hover ~ label.star-rating .far {
        display: none;
    }

    .rating-input input[type="radio"]:checked ~ label.star-rating .fas,
    .rating-input label.star-rating:hover .fas,
    .rating-input label.star-rating:hover ~ label.star-rating .fas {
        display: inline;
        color: #ffc107;
    }

    .rating-input label.star-rating:hover ~ label.star-rating .fas {
        color: #ffc107;
    }

    .rating-labels {
        min-height: 1.5rem;
    }

    .char-count-warning {
        color: #dc3545;
    }

    .char-count-success {
        color: #28a745;
    }
        .img-fluid {
        max-width: 150px;
        height: 150px;
    }
</style>
@endpush

@section('content')
<!-- Profile Content -->
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Profile Header -->
            <div class="profile-header profile-section">
                <div class="row align-items-center">
                    <!-- Profile Image Column -->
                    <div class="col-12 col-sm-4 col-md-3 text-center text-sm-start text-md-center mb-3 mb-sm-0">
                        <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                            alt="{{ $lawyer->user->name }}" class="profile-image img-fluid">
                    </div>
                    
                    <!-- Profile Info Column -->
                    <div class="col-12 col-sm-8 col-md-9">
                        <!-- Name and Badges - Responsive Stack -->
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center mb-2 gap-2">
                            <h1 class="mb-0 h3 h4-sm h2-md">{{ $lawyer->user->name }}</h1>
                            <div class="d-flex flex-wrap gap-1">
                                @if($lawyer->is_verified)
                                <span class="verified-badge small"><i class="fas fa-check-circle me-1"></i> Verified</span>
                                @endif
                                @if($lawyer->is_featured)
                                <span class="verified-badge bg-warning small"><i class="fas fa-star me-1"></i> Featured</span>
                                @endif
                            </div>
                        </div>

                        <!-- Specialization and Experience -->
                        <p class="text-muted mb-2 small">
                            {{ $lawyer->specializations->first()->name ?? 'Legal Professional' }}
                            @if($lawyer->years_of_experience)
                            • {{ $lawyer->years_of_experience }}+ years experience
                            @endif
                        </p>

                        <!-- Rating Section -->
                        <div class="rating mb-2 d-flex align-items-center flex-wrap">
                            <div class="me-2 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                    <i class="fas fa-star small"></i>
                                    @elseif($i - 0.5 <= $averageRating)
                                    <i class="fas fa-star-half-alt small"></i>
                                    @else
                                    <i class="far fa-star small"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-dark small">{{ number_format($averageRating, 1) }} ({{ $lawyer->reviews->count() }} reviews)</span>
                        </div>

                        <!-- Location -->
                        @if($lawyer->city && $lawyer->state)
                        <p class="mb-3 small"><i class="fas fa-map-marker-alt me-2"></i> {{ $lawyer->city }}, {{ $lawyer->state }}</p>
                        @endif

                        <!-- Specializations - Responsive Wrap -->
                        <div class="mb-3">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($lawyer->specializations as $specialization)
                                <span class="specialization-badge small">
                                    @if($specialization->icon)
                                    <i class="{{ $specialization->icon }} me-1"></i>
                                    @endif
                                    {{ $specialization->name }}
                                </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons - Responsive Stack -->
                        <div class="d-flex flex-column flex-sm-row flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm flex-fill text-nowrap">
                                <i class="fas fa-envelope me-1"></i> Contact
                            </button>
                            <button class="btn btn-outline-primary btn-sm flex-fill text-nowrap">
                                <i class="fas fa-calendar me-1"></i> Schedule
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="profile-section">
                <h3 class="section-title">About Me</h3>
                <p class="lead">{!! $lawyer->bio ?? 'No bio available.' !!}</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        @if($lawyer->bar_number)
                        <p><strong><i class="fas fa-id-card me-2"></i>Bar Number:</strong> {{ $lawyer->bar_number }}</p>
                        @endif
                        @if($lawyer->license_state)
                        <p><strong><i class="fas fa-map me-2"></i>License State:</strong> {{ $lawyer->license_state }}</p>
                        @endif
                        @if($lawyer->years_of_experience)
                        <p><strong><i class="fas fa-briefcase me-2"></i>Years of Experience:</strong> {{ $lawyer->years_of_experience }}+</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($lawyer->firm_name)
                        <p><strong><i class="fas fa-building me-2"></i>Firm Name:</strong> {{ $lawyer->firm_name }}</p>
                        @endif
                        @if($lawyer->website)
                        <p><strong><i class="fas fa-globe me-2"></i>Website:</strong>
                            <a href="{{ $lawyer->website }}" target="_blank">{{ $lawyer->website }}</a>
                        </p>
                        @endif
                        @if($lawyer->awards)
                        <p><strong><i class="fas fa-trophy me-2"></i>Awards:</strong> {{ $lawyer->awards }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Specializations Section -->
            @if($lawyer->specializations->count() > 0)
            <div class="profile-section">
                <h3 class="section-title">Areas of Expertise</h3>
                <div class="row">
                    @foreach($lawyer->specializations as $specialization)
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="{{ $specialization->icon ?? 'fas fa-gavel' }} fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $specialization->name }}</h5>
                                <p class="mb-0 text-muted">
                                    {{ $specialization->pivot->years_of_experience ?? $lawyer->years_of_experience }} years experience
                                </p>
                                @if($specialization->description)
                                <p class="mb-0 small text-muted mt-1">{{ Str::limit($specialization->description, 100) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Experience Section -->
            @if($lawyer->experiences->count() > 0)
            <div class="profile-section">
                <h3 class="section-title">Work Experience</h3>
                @foreach($lawyer->experiences as $experience)
                <div class="timeline-item">
                    <h5 class="mb-1">{{ $experience->position }}</h5>
                    <p class="text-primary mb-1 fw-bold">{{ $experience->company }}</p>
                    <p class="text-muted mb-2">
                        {{ $experience->start_date->format('M Y') }} -
                        @if($experience->is_current)
                        <span class="text-success">Present</span>
                        @else
                        {{ $experience->end_date->format('M Y') }}
                        @endif
                        · 
                        @if($experience->is_current)
                        {{ $experience->start_date->diffInYears(now()) }}+ years
                        @else
                        {{ $experience->start_date->diffInYears($experience->end_date) }}+ years
                        @endif
                    </p>
                    @if($experience->description)
                    <p class="mb-0">{{ $experience->description }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Education Section -->
            @if($lawyer->educations->count() > 0)
            <div class="profile-section">
                <h3 class="section-title">Education</h3>
                @foreach($lawyer->educations as $education)
                <div class="timeline-item">
                    <h5 class="mb-1">{{ $education->degree }}</h5>
                    <p class="text-primary mb-1 fw-bold">{{ $education->institution }}</p>
                    <p class="text-muted mb-2">Graduated: {{ $education->graduation_year }}</p>
                    @if($education->description)
                    <p class="mb-0">{{ $education->description }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Portfolio/Cases Section -->
            @if($lawyer->portfolios->count() > 0)
            <div class="profile-section">
                <h3 class="section-title">Notable Cases</h3>
                @foreach($lawyer->portfolios as $portfolio)
                <div class="card mb-3">
                    <div class="card-body">
                        @if($portfolio->is_featured)
                        <span class="badge bg-warning mb-2">Featured Case</span>
                        @endif
                        <h5 class="card-title">{{ $portfolio->title }}</h5>
                        @if($portfolio->case_type)
                        <span class="badge bg-primary mb-2">{{ $portfolio->case_type }}</span>
                        @endif
                        @if($portfolio->year)
                        <span class="badge bg-secondary mb-2">{{ $portfolio->year }}</span>
                        @endif
                        
                        @if($portfolio->description)
                        <p class="card-text">{{ Str::limit($portfolio->description, 200) }}</p>
                        @endif
                        
                        @if($portfolio->outcome)
                        <p class="mb-1"><strong>Outcome:</strong> 
                            <span class="badge {{ $this->isSuccessfulOutcome($portfolio->outcome) ? 'bg-success' : 'bg-info' }}">
                                {{ $portfolio->outcome }}
                            </span>
                        </p>
                        @endif
                        
                        @if($portfolio->case_value)
                        <p class="mb-1"><strong>Case Value:</strong> ${{ number_format($portfolio->case_value) }}</p>
                        @endif
                        
                        @if($portfolio->client_name)
                        <p class="mb-0 text-muted"><small>Client: {{ $portfolio->client_name }}</small></p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

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
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                <i class="fas fa-star"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    
                    @if($review->title)
                    <h6 class="text-primary mb-2">{{ $review->title }}</h6>
                    @endif
                    
                    <p class="mb-0">{{ $review->review }}</p>
                    
                    @if($review->is_featured)
                    <div class="mt-2">
                        <span class="badge bg-warning"><i class="fas fa-star me-1"></i>Featured Review</span>
                    </div>
                    @endif
                    
                    <!-- Review Actions (for lawyers or admins) -->
                    @auth
                        @if(auth()->user()->hasRole('super_admin') || auth()->user()->id === $lawyer->user_id)
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
                                @endif
                                
                                @if(auth()->user()->hasRole('super_admin'))
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
                        @endif
                    @endauth
                </div>
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
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Contact Widget -->
            <div class="contact-widget">
                <h4 class="mb-4 text-white">Contact Lawyer</h4>
                <div class="mb-4">
                    @if($lawyer->phone)
                    <p class="mb-3">
                        <i class="fas fa-phone me-2"></i> 
                        <a href="tel:{{ $lawyer->phone }}" class="text-white">{{ $lawyer->phone }}</a>
                    </p>
                    @endif
                    <p class="mb-3">
                        <i class="fas fa-envelope me-2"></i> 
                        <a href="mailto:{{ $lawyer->user->email }}" class="text-white">{{ $lawyer->user->email }}</a>
                    </p>
                    @if($lawyer->city && $lawyer->state)
                    <p class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i> {{ $lawyer->city }}, {{ $lawyer->state }}
                    </p>
                    @endif
                </div>
                <button class="btn btn-light w-100 mb-3 fw-bold">
                    <i class="fas fa-envelope me-1"></i> Send Message
                </button>
                <button class="btn btn-outline-light w-100 fw-bold">
                    <i class="fas fa-calendar me-1"></i> Schedule Consultation
                </button>
            </div>

            <!-- Stats Widget -->
            <div class="profile-section">
                <h4 class="section-title">Practice Stats</h4>
                <div class="row">
                    <div class="col-6">
                        <div class="stats-box">
                            <div class="stats-number">{{ $lawyer->years_of_experience }}+</div>
                            <div class="small">Years Experience</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-box">
                            <div class="stats-number">{{ $lawyer->portfolios->count() }}+</div>
                            <div class="small">Cases Handled</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-box">
                            <div class="stats-number">{{ $successRate }}%</div>
                            <div class="small">Success Rate</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-box">
                            <div class="stats-number">{{ $lawyer->reviews->count() }}</div>
                            <div class="small">Client Reviews</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Blog Posts -->
            @if($lawyer->blog_posts->count() > 0)
            <div class="profile-section">
                <h4 class="section-title">Latest Articles</h4>
                @foreach($lawyer->blog_posts as $post)
                <div class="card mb-3 border-0 shadow-sm">
                    @if($post->featured_image)
                    <img src="{{ asset('website/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 120px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ Str::limit($post->title, 50) }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $post->published_at->format('M j, Y') }}</small>
                            <span class="badge bg-primary">{{ $post->view_count }} views</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Location Map -->
            @if($lawyer->city && $lawyer->state)
            <div class="profile-section">
                <h4 class="section-title">Office Location</h4>
                <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; border-radius: 8px; color: white;">
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                        <p class="mb-0 fw-bold">{{ $lawyer->city }}, {{ $lawyer->state }}</p>
                        <small>Map integration available</small>
                    </div>
                </div>
                @if($lawyer->address)
                <p class="mt-3 mb-0 text-center">
                    <i class="fas fa-map-marker-alt me-2"></i> {{ $lawyer->address }}
                </p>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    console.log('visistor');
    // Time tracking for visitors
    let startTime = new Date();
    let timer;
    
    function updateTimeSpent() {
        const currentTime = new Date();
        const timeSpent = Math.floor((currentTime - startTime) / 1000); // in seconds
        
        // Send to server every 30 seconds
        if (timeSpent % 30 === 0) {
            console.log('sending...');
            fetch('{{ route("website.track-time", $lawyer->uuid) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ time_spent: timeSpent })
            });
        }
    }
    
    // Start tracking when page loads
    document.addEventListener('DOMContentLoaded', function() {
        timer = setInterval(updateTimeSpent, 30000); // Update every 30 seconds
    });
    
    // Stop tracking when user leaves
    window.addEventListener('beforeunload', function() {
        clearInterval(timer);
        const endTime = new Date();
        const totalTime = Math.floor((endTime - startTime) / 1000);
        
        // Send final time
        fetch('{{ route("website.track-time", $lawyer->uuid) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ time_spent: totalTime }),
            keepalive: true // Ensure request completes before page unloads
        });
    });
</script>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rating hover effects
    const ratingInputs = document.querySelectorAll('.rating-input input[type="radio"]');
    const ratingText = document.getElementById('ratingText');
    const reviewTextarea = document.getElementById('review');
    const charCount = document.getElementById('charCount');
    
    const ratingLabels = {
        1: 'Poor',
        2: 'Fair',
        3: 'Good',
        4: 'Very Good',
        5: 'Excellent'
    };

    // Rating hover and selection
    ratingInputs.forEach(input => {
        input.addEventListener('mouseenter', function() {
            ratingText.textContent = ratingLabels[this.value];
        });

        input.addEventListener('change', function() {
            ratingText.textContent = ratingLabels[this.value];
            ratingText.className = 'text-success fw-bold';
        });
    });

    // Character count for review
    if (reviewTextarea && charCount) {
        reviewTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            if (length > 450) {
                charCount.className = 'char-count-warning';
            } else if (length > 0) {
                charCount.className = 'char-count-success';
            } else {
                charCount.className = '';
            }
            
            if (length > 500) {
                this.value = this.value.substring(0, 500);
                charCount.textContent = 500;
            }
        });

        // Initialize character count
        charCount.textContent = reviewTextarea.value.length;
    }

    // Form submission handling
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const rating = document.querySelector('input[name="rating"]:checked');
            const review = document.getElementById('review').value.trim();
            
            if (!rating) {
                e.preventDefault();
                alert('Please select a rating');
                return false;
            }
            
            if (!review) {
                e.preventDefault();
                alert('Please write your review');
                return false;
            }
            
            if (review.length < 10) {
                e.preventDefault();
                alert('Please write a more detailed review (at least 10 characters)');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Submitting...';
            submitBtn.disabled = true;
        });
    }
});
</script>
@endpush