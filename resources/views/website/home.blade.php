<x-website.layout.master>

<!-- Hero Section -->
<section class="hero-section text-center" id="home">
    <img src="{{ asset('website/hero_image.JPG') }}" alt="Hero background" class="hero-bg">

    <div class="hero-overlay"></div>

    <div class="hero-content container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 mb-4">Find the Perfect Lawyer for Your Legal Needs</h1>
                <p class="lead mb-5">Connect with verified legal professionals specializing in various fields of law. Get the right representation for your case.</p>
                <x-website.ui.button href="#lawyers" variant="primary" size="lg" class="me-3">Find a Lawyer</x-website.ui.button>
                <x-website.ui.button href="#how-it-works" variant="outline-light" size="lg">Are you a Lawyer?</x-website.ui.button>
            </div>
        </div>
    </div>
</section>



<!-- Our Lawyers -->
<section class="section-padding" id="lawyers">
    <div class="container">
        <x-website.ui.section-heading title="Our Lawyers"
            subtitle="Browse our verified legal professionals — featured lawyers are highlighted." />
        <div class="row" id="lawyersContainer">
            @forelse($featuredLawyers as $lawyer)
                <x-website.cards.lawyer-card :lawyer="$lawyer" />
            @empty
                <div class="col-12">
                    <x-website.sections.empty-state icon="fas fa-user-tie"
                        title="No lawyers yet"
                        message="Check back soon — verified lawyers are joining all the time." />
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <x-website.ui.button :href="route('find-lawyeres')" variant="outline">View All Lawyers</x-website.ui.button>
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
        <x-website.ui.section-heading title="What Our Clients Say" center />
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
                        <img src="{{ asset('website/images/male_advocate_avatar.jpg') }}" alt="Advocate Kaleem" class="testimonial-img">
                        <div>
                            <h5 class="mb-0">Advocate Kaleem</h5>
                            <small class="text-muted">Corporate Law Specialist</small>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="mb-0">"Law-Skoolyst has been instrumental in expanding my client base. The platform efficiently connects me with clients who need expert corporate legal advice and services."</p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('website/images/female_advocate_avatar.jpg') }}" alt="Advocate Mis Samreen" class="testimonial-img">
                        <div>
                            <h5 class="mb-0">Advocate Mis Samreen</h5>
                            <small class="text-muted">Family Law Expert</small>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="mb-0">"As a family law practitioner, Law-Skoolyst has helped me reach clients who genuinely need my expertise. The platform's matching system ensures I work with cases that align with my specialization."</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

</x-website.layout.master>