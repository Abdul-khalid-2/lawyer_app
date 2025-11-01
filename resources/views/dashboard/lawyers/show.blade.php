<x-app-layout>
    <style>
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .profile-image {
            width: 150px;
            height: 150px;
            border: 5px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .stats-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .badge-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .section-title {
            border-left: 4px solid #667eea;
            padding-left: 15px;
            margin: 2rem 0 1rem 0;
            color: #2d3748;
        }
    </style>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : 'https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=150&h=150&fit=crop&crop=face' }}" 
                         alt="{{ $lawyer->user->name }}" 
                         class="profile-image rounded-circle">
                </div>
                <div class="col-md-6">
                    <h1 class="h2 mb-2">{{ $lawyer->user->name }}</h1>
                    <p class="mb-1">{{ $lawyer->firm_name ?? 'Independent Lawyer' }}</p>
                    <p class="mb-3">{{ $lawyer->bar_number }} • {{ $lawyer->license_state }}</p>
                    
                    @if($lawyer->specializations->count() > 0)
                        <div>
                            @foreach($lawyer->specializations as $specialization)
                                <span class="badge bg-light text-dark me-1">{{ $specialization->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('lawyer.profile.edit') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-md-3 mb-4">
                <div class="card stats-card text-center">
                    <div class="card-body">
                        <h3 class="text-primary">{{ $lawyer->years_of_experience }}+</h3>
                        <p class="text-muted mb-0">Years Experience</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stats-card text-center">
                    <div class="card-body">
                        <h3 class="text-success">{{ $lawyer->reviews->count() }}</h3>
                        <p class="text-muted mb-0">Total Reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stats-card text-center">
                    <div class="card-body">
                        <h3 class="text-info">{{ $lawyer->average_rating }}/5</h3>
                        <p class="text-muted mb-0">Average Rating</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stats-card text-center">
                    <div class="card-body">
                        <h3 class="text-warning">{{ $lawyer->blog_posts_count ?? 0 }}</h3>
                        <p class="text-muted mb-0">Blog Posts</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- About Section -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="section-title mb-0">About Me</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $lawyer->bio ?? 'No bio provided.' }}</p>
                        
                        @if($lawyer->services)
                            <h6 class="mt-4">Services Offered:</h6>
                            <p class="text-muted">{{ $lawyer->services }}</p>
                        @endif
                        
                        @if($lawyer->awards)
                            <h6 class="mt-4">Awards & Recognition:</h6>
                            <p class="text-muted">{{ $lawyer->awards }}</p>
                        @endif
                    </div>
                </div>

                <!-- Education Section -->
                @if($lawyer->educations->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="section-title mb-0">Education</h4>
                    </div>
                    <div class="card-body">
                        @foreach($lawyer->educations as $education)
                            <div class="mb-3 pb-3 border-bottom">
                                <h6 class="mb-1">{{ $education->degree }}</h6>
                                <p class="text-muted mb-1">{{ $education->institution }}</p>
                                <small class="text-primary">Graduated: {{ $education->graduation_year }}</small>
                                @if($education->description)
                                    <p class="mt-2 small">{{ $education->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Experience Section -->
                @if($lawyer->experiences->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="section-title mb-0">Experience</h4>
                    </div>
                    <div class="card-body">
                        @foreach($lawyer->experiences as $experience)
                            <div class="mb-3 pb-3 border-bottom">
                                <h6 class="mb-1">{{ $experience->position }}</h6>
                                <p class="text-muted mb-1">{{ $experience->company }}</p>
                                <small class="text-primary">
                                    {{ $experience->start_date->format('M Y') }} - 
                                    {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}
                                </small>
                                @if($experience->description)
                                    <p class="mt-2 small">{{ $experience->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Contact Information -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="section-title mb-0">Contact Information</h5>
                    </div>
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
                            <p class="mb-0">
                                <a href="{{ $lawyer->website }}" target="_blank">{{ $lawyer->website }}</a>
                            </p>
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
                        <div class="mb-3">
                            <strong><i class="fas fa-money-bill-wave text-primary me-2"></i>Hourly Rate</strong>
                            <p class="mb-0">${{ number_format($lawyer->hourly_rate, 2) }}/hour</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Verification Status -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="section-title mb-0">Verification Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Profile Verification:</span>
                            <span class="badge {{ $lawyer->is_verified ? 'bg-success' : 'bg-warning' }}">
                                {{ $lawyer->is_verified ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Account Status:</span>
                            <span class="badge {{ $lawyer->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $lawyer->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Recent Reviews -->
                @if($lawyer->reviews->count() > 0)
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="section-title mb-0">Recent Reviews</h5>
                    </div>
                    <div class="card-body">
                        @foreach($lawyer->reviews->take(3) as $review)
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong>{{ $review->user->name }}</strong>
                                    <span class="badge bg-primary">
                                        {{ $review->rating }}/5 <i class="fas fa-star ms-1"></i>
                                    </span>
                                </div>
                                <p class="small text-muted mb-2">{{ Str::limit($review->review, 100) }}</p>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </div>
                        @endforeach
                        @if($lawyer->reviews->count() > 3)
                            <a href="#" class="btn btn-outline-primary btn-sm w-100">View All Reviews</a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>