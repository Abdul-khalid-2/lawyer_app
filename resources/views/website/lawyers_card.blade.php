@forelse($lawyers as $lawyer)
<div class="col-md-6 col-lg-4 col-xl-3 mb-4">
    <div class="card lawyer-card h-100 shadow-sm border-0">
        <div class="card-body d-flex flex-column">
            <!-- Lawyer Header with Image and Basic Info -->
            <div class="lawyer-card">
                <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                    alt="{{ $lawyer->user->full_name }}" class="lawyer-img">

            </div>
            <div class="d-flex align-items-start mb-3">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 fw-bold text-dark">{{ $lawyer->user->name }}</h6>
                    <p class="text-primary small mb-1 fw-semibold">
                        <i class="fas fa-briefcase me-1"></i>{{ $lawyer->years_of_experience }}+ years experience
                    </p>
                    
                    <!-- Location -->
                    @if($lawyer->city || $lawyer->state)
                        <p class="text-muted small mb-0">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $lawyer->city }}{{ $lawyer->city && $lawyer->state ? ', ' : '' }}{{ $lawyer->state }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Specializations -->
            @if($lawyer->specializations->count() > 0)
                <div class="mb-3">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($lawyer->specializations->take(2) as $specialization)
                            <span class="badge bg-light text-dark border small px-2 py-1">
                                {{ $specialization->name }}
                            </span>
                        @endforeach
                        @if($lawyer->specializations->count() > 2)
                            <span class="badge bg-light text-muted border small px-2 py-1">
                                +{{ $lawyer->specializations->count() - 2 }} more
                            </span>
                        @endif
                        @if($lawyer->is_featured)
                            <span class="badge bg-warning text-dark small">Featured</span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Rating Section -->
            <div class="mb-3">
                @php
                    $averageRating = $lawyer->reviews->avg('rating');
                    $reviewCount = $lawyer->reviews->count();
                @endphp
                
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="rating-stars me-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($averageRating))
                                    <!-- Full star -->
                                    <i class="fas fa-star text-warning small"></i>
                                @elseif($i - 0.5 <= $averageRating)
                                    <!-- Half star -->
                                    <i class="fas fa-star-half-alt text-warning small"></i>
                                @else
                                    <!-- Empty star -->
                                    <i class="far fa-star text-warning small"></i>
                                @endif
                            @endfor
                        </div>
                        @if($reviewCount > 0)
                            <span class="text-primary fw-semibold small ms-1">{{ number_format($averageRating, 1) }}/{{ $reviewCount }}</span>
                        @endif
                    </div>
                    
                    @if($reviewCount > 0)
                        {{-- <small class="text-muted">({{ $reviewCount }})</small> --}}
                    @endif
                </div>
                
                @if($reviewCount === 0)
                    <small class="text-muted">
                        <i class="far fa-star text-muted me-1"></i>No reviews yet
                    </small>
                @endif
            </div>

            <!-- Bio Excerpt -->
            @if($lawyer->bio)
                <div class="mb-3 flex-grow-1">
                    <p class="card-text small text-muted mb-0 line-clamp-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ Str::limit(strip_tags($lawyer->bio), 120) }}
                    </p>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-auto">
                <div class="d-grid gap-2">
                    <a href="{{ route('website.lawyers.profile', $lawyer->uuid) }}" 
                       class="btn btn-primary btn-sm fw-semibold py-2">
                        <i class="fas fa-user-circle me-1"></i>View Profile
                    </a>
                    @if($lawyer->user->phone)
                        <div class="d-flex gap-2">
                            <a href="tel:{{ $lawyer->user->phone }}" 
                               class="btn btn-outline-success btn-sm flex-fill py-2">
                                <i class="fas fa-phone me-1"></i> Call
                            </a>
                            <a href="https://wa.me/{{ $lawyer->user->phone }}" 
                               target="_blank"
                               class="btn btn-outline-success btn-sm px-3 py-2">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@empty
@if(!isset($hideEmptyMessage) || !$hideEmptyMessage)
    <div class="col-12 text-center py-5">
        <div class="text-muted">
            <i class="fas fa-search fa-3x mb-3 opacity-50"></i>
            <h5 class="mb-2">No lawyers found</h5>
            <p class="mb-0">Try adjusting your search criteria or filters</p>
        </div>
    </div>
@endif
@endforelse