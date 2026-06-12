<!-- Profile Header -->
<div class="profile-header profile-section">
    <div class="row align-items-center">
        <!-- Profile Image Column -->
        <div class="col-12 col-sm-4 col-md-3 text-center text-sm-start text-md-center mb-3 mb-sm-0">
            <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                alt="{{ $lawyer->user->name }}" class="profile-image img-fluid">
        </div>

        <!-- Profile Info Column -->
        <div class="col-12 col-sm-8 col-md-9">
            <!-- Name and Badges - Responsive Stack -->
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center mb-2 gap-2">
                <h1 class="mb-0 h3 h4-sm h2-md">{{ $lawyer->user->name }}</h1>
                <div class="d-flex flex-wrap gap-1">
                    @if($lawyer->is_verified)
                    <span class="verified-badge small"><i class="fas fa-check-circle me-1"></i> Verified</span>
                    @endif
                    @if($lawyer->is_featured)
                    <span class="verified-badge bg-warning small"><i class="fas fa-star me-1"></i> Featured</span>
                    @endif
                </div>
            </div>

            <!-- Specialization and Experience -->
            <p class="text-muted mb-2 small">
                {{ $lawyer->specializations->first()->name ?? 'Legal Professional' }}
                @if($lawyer->years_of_experience)
                • {{ $lawyer->years_of_experience }}+ years experience
                @endif
            </p>

            <!-- Rating Section -->
            <div class="rating mb-2 d-flex align-items-center flex-wrap">
                <div class="me-2 mb-1">
                    <x-website.ui.rating :value="$averageRating" :show-value="false" />
                </div>
                <span class="text-dark small">{{ number_format($averageRating, 1) }} ({{ $lawyer->reviews->count() }} reviews)</span>
            </div>

            <!-- Location -->
            @if($lawyer->city && $lawyer->state)
            <p class="mb-3 small"><i class="fas fa-map-marker-alt me-2"></i> {{ $lawyer->city }}, {{ $lawyer->state }}</p>
            @endif

            <!-- Specializations - Responsive Wrap -->
            <div class="mb-3">
                <div class="d-flex flex-wrap gap-1">
                    @foreach($lawyer->specializations as $specialization)
                    <span class="specialization-badge small">
                        @if($specialization->icon)
                        <i class="{{ $specialization->icon }} me-1"></i>
                        @endif
                        {{ $specialization->name }}
                    </span>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons - Responsive Stack -->
            <div class="d-flex flex-column flex-sm-row flex-wrap gap-2">
                <a href="mailto:{{ $lawyer->user->email }}?subject={{ rawurlencode('Legal consultation enquiry') }}"
                    class="btn btn-primary btn-sm flex-fill text-nowrap">
                    <i class="fas fa-envelope me-1"></i> Contact
                </a>
                <button type="button" class="btn btn-outline-primary btn-sm flex-fill text-nowrap"
                    data-bs-toggle="modal" data-bs-target="#scheduleModal">
                    <i class="fas fa-calendar me-1"></i> Schedule
                </button>
            </div>
        </div>
    </div>
</div>
