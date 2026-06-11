<x-website.layout.master title="How It Works - Law-Skoolyst"
    description="Learn how Law-Skoolyst connects you with the right lawyer in three simple steps — search, compare and consult verified legal professionals.">

<!-- Hero Section -->
<section class="hero-section text-center" id="home">
    <div class="hero-overlay"></div>

    <div class="hero-content container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 mb-4 text-white">Your Trusted Legal Partner for Justice And Rights</h1>
                <p class="lead mb-5 text-light">Expert legal counsel from experienced advocates and law firms. Schedule consultations, get case reviews, and find the right representation for your legal matters.</p>
                <x-website.ui.button :href="route('find-lawyeres')" variant="primary" size="lg" class="me-3">Browse Lawyers</x-website.ui.button>
                <x-website.ui.button href="#how-it-works" variant="outline-light" size="lg">Legal Consultation</x-website.ui.button>
            </div>
        </div>
    </div>
</section>



<!-- How It Works -->
<section class="section-padding bg-light" id="how-it-works">
    <div class="container">
        <x-website.ui.section-heading title="How It Works" center />
        <div class="row">
            <div class="col-md-4 mb-4">
                <x-website.ui.icon-box icon="fas fa-search" number="1" title="Search Lawyers">
                    Browse through our verified lawyer profiles by specialization, location, or experience.
                </x-website.ui.icon-box>
            </div>
            <div class="col-md-4 mb-4">
                <x-website.ui.icon-box icon="fas fa-user-check" number="2" title="Connect">
                    Contact lawyers directly through our platform to discuss your legal needs.
                </x-website.ui.icon-box>
            </div>
            <div class="col-md-4 mb-4">
                <x-website.ui.icon-box icon="fas fa-handshake" number="3" title="Get Representation">
                    Hire the right lawyer and get the legal representation you deserve.
                </x-website.ui.icon-box>
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
                <x-website.ui.button variant="primary" class="mt-3" data-bs-toggle="modal" data-bs-target="#registerModal">Join as a Lawyer</x-website.ui.button>
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



</x-website.layout.master>