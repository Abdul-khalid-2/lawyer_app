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

<!-- Search Section -->
<!-- <section class="section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="search-form">
                    <h3 class="mb-4">Find Your Lawyer</h3>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="Specialization (e.g. Criminal Law)">
                        </div>
                        <div class="col-md-5 mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="Location (City or State)">
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- Featured Lawyers -->
<section class="section-padding" id="lawyers">
    <div class="container">
        <h2 class="section-title">Featured Lawyers</h2>
        <div class="row" id="lawyersContainer">
            <!-- Lawyer Card 1 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="lawyer-card">
                    <img src="https://images.pexels.com/photos/2182970/pexels-photo-2182970.jpeg?auto=compress&cs=tinysrgb&w=600" alt="John Smith" class="lawyer-img">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="mb-0">John Smith</h4>
                            <span class="badge bg-success">Verified</span>
                        </div>
                        <p class="text-muted mb-2">
                            Criminal Law • 15 years experience
                        </p>
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            New York, NY
                        </p>
                        <div class="d-flex">
                            <a href="#" class="btn btn-outline-primary me-2">View Profile</a>
                            <a href="#" class="btn btn-primary">Contact</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lawyer Card 2 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="lawyer-card">
                    <img src="https://images.pexels.com/photos/3769021/pexels-photo-3769021.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Sarah Johnson" class="lawyer-img">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="mb-0">Sarah Johnson</h4>
                            <span class="badge bg-success">Verified</span>
                        </div>
                        <p class="text-muted mb-2">
                            Family Law • 12 years experience
                        </p>
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Los Angeles, CA
                        </p>
                        <div class="d-flex">
                            <a href="#" class="btn btn-outline-primary me-2">View Profile</a>
                            <a href="#" class="btn btn-primary">Contact</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lawyer Card 3 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="lawyer-card">
                    <img src="https://images.pexels.com/photos/5668774/pexels-photo-5668774.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Michael Brown" class="lawyer-img">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="mb-0">Michael Brown</h4>
                            <span class="badge bg-success">Verified</span>
                        </div>
                        <p class="text-muted mb-2">
                            Corporate Law • 20 years experience
                        </p>
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Chicago, IL
                        </p>
                        <div class="d-flex">
                            <a href="#" class="btn btn-outline-primary me-2">View Profile</a>
                            <a href="#" class="btn btn-primary">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline-primary">
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
                    <div class="stats-number">500+</div>
                    <div>Verified Lawyers</div>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stats-box">
                    <div class="stats-number">10,000+</div>
                    <div>Satisfied Clients</div>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stats-box">
                    <div class="stats-number">25,000+</div>
                    <div>Cases Handled</div>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4">
                <div class="stats-box">
                    <div class="stats-number">150+</div>
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
                    <p class="mb-0">"I was struggling with a property dispute. Law-Skoolyst connected me with an expert real estate lawyer who resolved my case efficiently."</p>
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
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://images.pexels.com/photos/712513/pexels-photo-712513.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Client" class="testimonial-img">
                        <div>
                            <h5 class="mb-0">David Martinez</h5>
                            <small class="text-muted">Corporate Law Client</small>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <p class="mb-0">"Excellent service! The corporate lawyer helped us navigate complex business regulations and saved our company from potential legal issues."</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('js')
<script src="{{ asset('website/js/home.js') }}"></script>
@endpush

@endsection