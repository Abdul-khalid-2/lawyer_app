@extends('website.layout.master')

@push('css')
<link rel="stylesheet" href="{{ asset('website/css/home.css') }}">
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section text-center" id="home">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 mb-4">Find the Perfect Lawyer for Your Legal Needs</h1>
                <p class="lead mb-5">Connect with verified legal professionals specializing in various fields of law. Get the right representation for your case.</p>
                <a href="#lawyers" class="btn btn-primary btn-lg me-3">Find a Lawyer</a>
                <a href="#how-it-works" class="btn btn-outline-light btn-lg">Are you a Lawyer?</a>
            </div>
        </div>
    </div>
</section>


<!-- Featured Lawyers -->
<section class="section-padding" id="lawyers">
    <div class="container">
        <h2 class="section-title">Featured Lawyers</h2>
        <div class="row" id="lawyersContainer">
            @forelse($featuredLawyers as $lawyer)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="lawyer-card">
                    <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                        alt="{{ $lawyer->user->full_name }}" class="lawyer-img">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="mb-0">{{ $lawyer->user->name }}</h4>
                            @if($lawyer->is_verified)
                            <span class="badge bg-success">Verified</span>
                            @endif
                        </div>
                        <p class="text-muted mb-2">
                            {{ $lawyer->specializations->first()->name ?? 'Legal Professional' }} •
                            {{ $lawyer->years_of_experience }} years experience
                        </p>
                        <!-- <div class="mb-3">
                            @foreach($lawyer->specializations->take(2) as $specialization)
                            <span class="specialization-badge">{{ $specialization->name }}</span>
                            @endforeach
                        </div> -->
                        @php
                        $averageRating = $lawyer->reviews->avg('rating');
                        $reviewCount = $lawyer->reviews->count();
                        @endphp
                        <!-- <div class="rating mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <=floor($averageRating))
                                <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $averageRating)
                                    <i class="fas fa-star-half-alt"></i>
                                    @else
                                    <i class="far fa-star"></i>
                                    @endif
                                    @endfor
                                    <span class="ms-1">{{ number_format($averageRating, 1) }} ({{ $reviewCount }} reviews)</span>
                        </div> -->
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $lawyer->city ? $lawyer->city . ', ' . $lawyer->state : 'Location not specified' }}
                        </p>
                        <div class="d-flex">
                            <a href="#" class="btn btn-outline-primary me-2">View Profile</a>
                            <a href="#contact" class="btn btn-primary">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">No featured lawyers available at the moment.</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('find-lawyeres') }}" class="btn btn-outline-primary">
                View All Lawyers
            </a>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="section-padding bg-light" id="how-it-works">
    <div class="container">
        <h2 class="section-title text-center">How It Works</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="mb-4">
                    <i class="fas fa-search fa-3x text-secondary"></i>
                </div>
                <h4>1. Search Lawyers</h4>
                <p>Browse through our verified lawyer profiles by specialization, location, or experience.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="mb-4">
                    <i class="fas fa-user-check fa-3x text-secondary"></i>
                </div>
                <h4>2. Connect</h4>
                <p>Contact lawyers directly through our platform to discuss your legal needs.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="mb-4">
                    <i class="fas fa-handshake fa-3x text-secondary"></i>
                </div>
                <h4>3. Get Representation</h4>
                <p>Hire the right lawyer and get the legal representation you deserve.</p>
            </div>
        </div>

        <div class="row mt-5 pt-5">
            <div class="col-lg-6">
                <h3 class="mb-4">For Clients</h3>
                <p>Find the perfect lawyer for your specific legal needs. Our platform makes it easy to compare profiles, read reviews, and connect with legal professionals.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-secondary me-2"></i> Browse lawyer profiles</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-secondary me-2"></i> Read client reviews</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-secondary me-2"></i> Schedule consultations</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <h3 class="mb-4">For Lawyers</h3>
                <p>Join our platform to showcase your expertise, connect with clients, and grow your legal practice. We provide the tools you need to succeed.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-secondary me-2"></i> Create your profile</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-secondary me-2"></i> Showcase your experience</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-secondary me-2"></i> Connect with clients</li>
                </ul>
                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#registerModal">Join as a Lawyer</button>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stats-box">
                    <div class="stats-number" id="lawyersCount">{{ $stats['lawyersCount'] }}+</div>
                    <div>Verified Lawyers</div>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stats-box">
                    <div class="stats-number" id="clientsCount">{{ $stats['clientsCount'] }}+</div>
                    <div>Satisfied Clients</div>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stats-box">
                    <div class="stats-number" id="casesCount">{{ $stats['casesCount'] }}+</div>
                    <div>Cases Handled</div>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stats-box">
                    <div class="stats-number" id="citiesCount">{{ $stats['citiesCount'] }}+</div>
                    <div>Cities Served</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="section-padding bg-light">
    <div class="container">
        <h2 class="section-title text-center">What Our Clients Say</h2>
        <div class="row">
            @forelse($testimonials as $testimonial)
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://images.pexels.com/photos/712513/pexels-photo-712513.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            alt="{{ $testimonial->client_name }}" class="testimonial-img">
                        <div>
                            <h5 class="mb-0">{{ $testimonial->client_name }}</h5>
                            <small class="text-muted">Client of {{ $testimonial->lawyer->full_name }}</small>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=$testimonial->rating)
                            <i class="fas fa-star"></i>
                            @else
                            <i class="far fa-star"></i>
                            @endif
                            @endfor
                    </div>
                    <p class="mb-0">"{{ Str::limit($testimonial->review, 150) }}"</p>
                </div>
            </div>
            @empty
            <!-- <div class="col-12 text-center">
                <p class="text-muted">No testimonials available yet.</p>
            </div> -->

            <div class="col-lg-4 mb-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://images.pexels.com/photos/1036623/pexels-photo-1036623.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Client" class="testimonial-img">
                        <div>
                            <h5 class="mb-0">Sarah Williams</h5>
                            <small class="text-muted">Real Estate Client</small>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="mb-0">"I was struggling with a property dispute. LegalConnect connected me with an expert real estate lawyer who resolved my case efficiently."</p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://images.pexels.com/photos/1181519/pexels-photo-1181519.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Client" class="testimonial-img">
                        <div>
                            <h5 class="mb-0">Robert Chen</h5>
                            <small class="text-muted">Family Law Client</small>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="mb-0">"The family lawyer I found here was compassionate and knowledgeable. She helped me through a difficult custody case with great expertise."</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@push('js')
<script src="{{ asset('website/js/home.js') }}"></script>
@endpush

@endsection