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
    <a href="mailto:{{ $lawyer->user->email }}?subject={{ rawurlencode('Legal consultation enquiry') }}"
        class="btn btn-light w-100 mb-3 fw-bold">
        <i class="fas fa-envelope me-1"></i> Send Message
    </a>
    <button type="button" class="btn btn-outline-light w-100 fw-bold"
        data-bs-toggle="modal" data-bs-target="#scheduleModal">
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
            <h6 class="card-title">
                <a href="{{ route('website.blog.show', $post->slug) }}"
                    class="text-dark text-decoration-none">
                    {{ Str::limit($post->title, 50) }}
                </a>
            </h6>
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
