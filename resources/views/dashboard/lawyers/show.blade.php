<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header :title="$lawyer->user->name" icon="fas fa-user-tie"
            :subtitle="($lawyer->firm_name ?? 'Independent Lawyer') . ($lawyer->bar_number ? ' · ' . $lawyer->bar_number : '')">
            <a href="{{ route('educations.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-graduation-cap me-1"></i> Education
            </a>
            <a href="{{ route('experiences.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-briefcase me-1"></i> Experience
            </a>
            <a href="{{ route('lawyer.profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit Profile
            </a>
        </x-dashboard.page-header>

        <!-- Profile summary -->
        <div class="card mb-4">
            <div class="card-body d-flex flex-column flex-sm-row align-items-center gap-3">
                <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : 'https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=150&h=150&fit=crop&crop=face' }}"
                    alt="{{ $lawyer->user->name }}" class="rounded-circle"
                    style="width: 90px; height: 90px; object-fit: cover;">
                <div class="flex-grow-1 text-center text-sm-start">
                    <h4 class="mb-1">{{ $lawyer->user->name }}</h4>
                    <p class="text-muted mb-2">
                        {{ $lawyer->firm_name ?? 'Independent Lawyer' }}
                        @if($lawyer->license_state) · {{ $lawyer->license_state }} @endif
                    </p>
                    <div class="d-flex flex-wrap gap-1 justify-content-center justify-content-sm-start">
                        @foreach($lawyer->specializations as $specialization)
                            <span class="badge bg-light text-dark border">{{ $specialization->name }}</span>
                        @endforeach
                        <span class="badge {{ $lawyer->is_verified ? 'bg-success' : 'bg-warning' }}">
                            <i class="fas fa-{{ $lawyer->is_verified ? 'check-circle' : 'clock' }} me-1"></i>{{ $lawyer->is_verified ? 'Verified' : 'Pending' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-2">
            <div class="col-md-3 col-sm-6 mb-4">
                <x-dashboard.stat-card label="Years Experience" :value="$lawyer->years_of_experience . '+'"
                    icon="fas fa-briefcase" variant="primary" />
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <x-dashboard.stat-card label="Total Reviews" :value="$lawyer->reviews->count()"
                    icon="fas fa-comments" variant="info" />
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <x-dashboard.stat-card label="Average Rating" :value="number_format($lawyer->average_rating, 1) . '/5'"
                    icon="fas fa-star" variant="warning" />
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <x-dashboard.stat-card label="Blog Posts" :value="$lawyer->blog_posts()->count()"
                    icon="fas fa-blog" variant="success" />
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">About Me</h5></div>
                    <div class="card-body">
                        <p class="card-text">{{ $lawyer->bio ?? 'No bio provided.' }}</p>
                        @if($lawyer->services)
                            <h6 class="mt-4">Services Offered</h6>
                            <p class="text-muted mb-0">{{ $lawyer->services }}</p>
                        @endif
                        @if($lawyer->awards)
                            <h6 class="mt-4">Awards &amp; Recognition</h6>
                            <p class="text-muted mb-0">{{ $lawyer->awards }}</p>
                        @endif
                    </div>
                </div>

                @if($lawyer->educations->count() > 0)
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Education</h5></div>
                    <div class="card-body">
                        @foreach($lawyer->educations as $education)
                            <div class="mb-3 pb-3 border-bottom">
                                <h6 class="mb-1">{{ $education->degree }}</h6>
                                <p class="text-muted mb-1">{{ $education->institution }}</p>
                                <small class="text-primary">Graduated: {{ $education->graduation_year }}</small>
                                @if($education->description)
                                    <p class="mt-2 small mb-0">{{ $education->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($lawyer->experiences->count() > 0)
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Experience</h5></div>
                    <div class="card-body">
                        @foreach($lawyer->experiences as $experience)
                            <div class="mb-3 pb-3 border-bottom">
                                <h6 class="mb-1">{{ $experience->position }}</h6>
                                <p class="text-muted mb-1">{{ $experience->company }}</p>
                                <small class="text-primary">
                                    {{ $experience->start_date->format('M Y') }} -
                                    {{ $experience->is_current ? 'Present' : optional($experience->end_date)->format('M Y') }}
                                </small>
                                @if($experience->description)
                                    <p class="mt-2 small mb-0">{{ $experience->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Contact Information</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong><i class="fas fa-envelope text-primary me-2"></i>Email</strong>
                            <p class="mb-0">{{ $lawyer->user->email }}</p>
                        </div>
                        @if($lawyer->user->phone)
                        <div class="mb-3">
                            <strong><i class="fas fa-phone text-primary me-2"></i>Phone</strong>
                            <p class="mb-0">{{ $lawyer->user->phone }}</p>
                        </div>
                        @endif
                        @if($lawyer->website)
                        <div class="mb-3">
                            <strong><i class="fas fa-globe text-primary me-2"></i>Website</strong>
                            <p class="mb-0"><a href="{{ $lawyer->website }}" target="_blank">{{ $lawyer->website }}</a></p>
                        </div>
                        @endif
                        @if($lawyer->address)
                        <div class="mb-3">
                            <strong><i class="fas fa-map-marker-alt text-primary me-2"></i>Address</strong>
                            <p class="mb-0">{{ $lawyer->address }}</p>
                            @if($lawyer->city && $lawyer->state)
                                <p class="mb-0">{{ $lawyer->city }}, {{ $lawyer->state }} {{ $lawyer->zip_code }}</p>
                            @endif
                        </div>
                        @endif
                        @if($lawyer->hourly_rate)
                        <div class="mb-0">
                            <strong><i class="fas fa-money-bill-wave text-primary me-2"></i>Hourly Rate</strong>
                            <p class="mb-0">Rs.{{ number_format($lawyer->hourly_rate, 2) }}/hour</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Verification Status</h5></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Profile Verification</span>
                            <span class="badge {{ $lawyer->is_verified ? 'bg-success' : 'bg-warning' }}">
                                {{ $lawyer->is_verified ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Account Status</span>
                            <span class="badge {{ $lawyer->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $lawyer->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($lawyer->reviews->count() > 0)
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Recent Reviews</h5></div>
                    <div class="card-body">
                        @foreach($lawyer->reviews->take(3) as $review)
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong>{{ $review->user->name }}</strong>
                                    <span class="badge bg-primary">{{ $review->rating }}/5 <i class="fas fa-star ms-1"></i></span>
                                </div>
                                <p class="small text-muted mb-2">{{ Str::limit($review->review, 100) }}</p>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
