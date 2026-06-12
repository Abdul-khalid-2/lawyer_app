<x-website.layout.master title="About Us - Law-Skoolyst"
    description="Law-Skoolyst connects clients with verified lawyers and legal experts across Pakistan. Learn about our mission, values and how we help.">

    <x-website.sections.page-hero icon="fas fa-scale-balanced"
        title="About Law-Skoolyst"
        subtitle="We connect people who need legal help with verified, experienced lawyers — making quality legal representation accessible to everyone." />

    <!-- Mission -->
    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <x-website.ui.section-heading title="Our Mission" />
                    <p class="lead text-muted">
                        Finding the right lawyer should be simple, transparent and trustworthy. Law-Skoolyst was built to
                        bridge the gap between clients and legal professionals — so you can compare verified profiles, read
                        genuine client reviews, and connect directly with the expert who fits your case.
                    </p>
                    <p class="text-muted">
                        Every lawyer on our platform is verified, and every review is moderated. Whether you need civil,
                        criminal, family, corporate or tax expertise, we help you make an informed choice with confidence.
                    </p>
                    <x-website.ui.button :href="route('find-lawyeres')" variant="primary" icon="fas fa-search">Find a Lawyer</x-website.ui.button>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('website/hero_image.JPG') }}" alt="About Law-Skoolyst"
                        class="img-fluid rounded shadow-sm" style="width:100%; height:360px; object-fit:cover;">
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="section-padding bg-light">
        <div class="container">
            <x-website.ui.section-heading title="What We Stand For"
                subtitle="The principles that guide everything we build." center />
            <div class="row g-4">
                <div class="col-md-4">
                    <x-website.ui.icon-box icon="fas fa-shield-halved" title="Verified & Trusted">
                        Every lawyer is verified before going live, so you connect only with genuine, qualified professionals.
                    </x-website.ui.icon-box>
                </div>
                <div class="col-md-4">
                    <x-website.ui.icon-box icon="fas fa-handshake" title="Transparent">
                        Real profiles, real qualifications and moderated client reviews — no hidden surprises.
                    </x-website.ui.icon-box>
                </div>
                <div class="col-md-4">
                    <x-website.ui.icon-box icon="fas fa-bolt" title="Accessible">
                        Search, compare and reach out in minutes — quality legal help, available to everyone.
                    </x-website.ui.icon-box>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 text-center mb-4">
                    <div class="stats-box">
                        <div class="stats-number">{{ $stats['lawyersCount'] }}+</div>
                        <div>Verified Lawyers</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4">
                    <div class="stats-box">
                        <div class="stats-number">{{ $stats['clientsCount'] }}+</div>
                        <div>Registered Users</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4">
                    <div class="stats-box">
                        <div class="stats-number">{{ $stats['casesCount'] }}+</div>
                        <div>Cases Handled</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 text-center mb-4">
                    <div class="stats-box">
                        <div class="stats-number">{{ $stats['citiesCount'] }}+</div>
                        <div>Cities Served</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Practice areas -->
    @if($specializations->count() > 0)
    <section class="section-padding bg-light">
        <div class="container">
            <x-website.ui.section-heading title="Areas of Expertise"
                subtitle="Find specialists across a wide range of legal practice areas." center />
            <div class="d-flex flex-wrap justify-content-center gap-2">
                @foreach($specializations as $spec)
                    <x-website.ui.badge variant="specialization" :icon="$spec->icon ?? 'fas fa-gavel'">{{ $spec->name }}</x-website.ui.badge>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA -->
    <section class="lc-page-hero lc-page-hero--center">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="lc-page-hero__title">Ready to find your lawyer?</h2>
                    <p class="lc-page-hero__subtitle mx-auto">Browse verified legal professionals and connect with the right expert for your case today.</p>
                    <div class="lc-page-hero__actions d-flex flex-wrap gap-2 justify-content-center">
                        <x-website.ui.button :href="route('find-lawyeres')" variant="primary" size="lg" icon="fas fa-search">Find a Lawyer</x-website.ui.button>
                        <x-website.ui.button :href="route('website.howItWork')" variant="outline-light" size="lg">How It Works</x-website.ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-website.layout.master>
