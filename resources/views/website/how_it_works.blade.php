@extends('website.layout.master')

@push('css')
<link rel="stylesheet" href="{{ asset('website/css/home.css') }}">
<style>
    /* .hero-section {
        background: 
            linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)), 
            url('{{ asset('website/images/hero-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        padding: 120px 0;
        color: white;
    } */
    .hero-section {
        position: relative;
        overflow: hidden;
        color: white;
        padding: 120px 0;
    }

    .hero-section .hero-bg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
    }

    .hero-section .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(44, 62, 80, 0.8);
        z-index: 2;
    }

    .hero-section .hero-content {
        position: relative;
        z-index: 3;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section text-center" id="home">
    <!-- <img src="{{ asset('website/hero_image.JPG') }}" alt="Hero background" class="hero-bg"> -->

    <div class="hero-overlay"></div>

    <div class="hero-content container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 mb-4 text-white">Your Trusted Legal Partner for Justice And Rights</h1>
                <p class="lead mb-5 text-light">Expert legal counsel from experienced advocates and law firms. Schedule consultations, get case reviews, and find the right representation for your legal matters.</p>
                <a href="{{ route('find-lawyeres') }}" class="btn btn-primary btn-lg me-3">Browse Lawyers</a>
                <a href="#how-it-works" class="btn btn-outline-light btn-lg">Legal Consultation</a>
            </div>
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



@push('js')
<script src="{{ asset('website/js/home.js') }}"></script>
@endpush

@endsection