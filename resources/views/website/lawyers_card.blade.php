@forelse($lawyers as $lawyer)
<div class="col-md-6 col-lg-4 mb-4">
    <div class="card lawyer-card h-100">
        <div class="card-body">
            <!-- Lawyer Header -->
            <div class="d-flex align-items-start mb-3">
                <img src="{{ $lawyer->user->profile_image ? asset('website/'.$lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                     alt="{{ $lawyer->user->name }}" 
                     class="rounded-circle me-3" 
                     width="60" 
                     height="60"
                     style="object-fit: cover;">
                <div class="flex-grow-1">
                    <h5 class="card-title mb-1">{{ $lawyer->user->name }}</h5>
                    <p class="text-muted small mb-1">
                        {{ $lawyer->years_of_experience }}+ years experience
                    </p>
                    @if($lawyer->is_featured)
                        <span class="badge bg-warning text-dark small">Featured</span>
                    @endif
                </div>
            </div>

            <!-- Specializations -->
            @if($lawyer->specializations->count() > 0)
                <div class="mb-3">
                    @foreach($lawyer->specializations->take(2) as $specialization)
                        <span class="badge specialization-badge small me-1 mb-1">
                            {{ $specialization->name }}
                        </span>
                    @endforeach
                    @if($lawyer->specializations->count() > 2)
                        <span class="badge specialization-badge small">
                            +{{ $lawyer->specializations->count() - 2 }} more
                        </span>
                    @endif
                </div>
            @endif

            <!-- Location -->
            @if($lawyer->city || $lawyer->state)
                <p class="text-muted small mb-2">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    {{ $lawyer->city }}{{ $lawyer->city && $lawyer->state ? ', ' : '' }}{{ $lawyer->state }}
                </p>
            @endif

            <!-- Hourly Rate -->
            @if($lawyer->hourly_rate)
                <p class="mb-2">
                    <strong>${{ number_format($lawyer->hourly_rate) }}/hour</strong>
                </p>
            @endif

            <!-- Rating -->
            @php
                $averageRating = $lawyer->reviews->avg('rating');
                $reviewCount = $lawyer->reviews->count();
            @endphp
            @if($reviewCount > 0)
                <div class="d-flex align-items-center mb-3">
                    <div class="rating-stars me-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $averageRating ? '' : '-o' }} small"></i>
                        @endfor
                    </div>
                    <small class="text-muted">({{ $reviewCount }} review{{ $reviewCount !== 1 ? 's' : '' }})</small>
                </div>
            @else
                <div class="mb-3">
                    <small class="text-muted">No reviews yet</small>
                </div>
            @endif

            <!-- Bio Excerpt -->
            @if($lawyer->bio)
                <p class="card-text small text-muted mb-3">
                    {{ Str::limit(strip_tags($lawyer->bio), 100) }}
                </p>
            @endif

            <!-- Action Buttons -->
            <div class="d-grid gap-2">
                <a href="#" 
                   class="btn btn-outline-primary btn-sm">
                    View Profile
                </a>
                @if($lawyer->user->phone)
                    <a href="tel:{{ $lawyer->user->phone }}" 
                       class="btn btn-outline-success btn-sm">
                        <i class="fas fa-phone me-1"></i> Call
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@empty
@if(!isset($hideEmptyMessage) || !$hideEmptyMessage)
    <div class="col-12 text-center">
        <p class="text-muted">No lawyers found matching your criteria.</p>
    </div>
@endif
@endforelse