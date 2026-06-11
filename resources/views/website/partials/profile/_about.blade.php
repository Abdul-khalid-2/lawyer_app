<!-- About Section -->
<div class="profile-section">
    <h3 class="section-title">About Me</h3>
    <p class="lead">{!! $lawyer->bio ?? 'No bio available.' !!}</p>

    <div class="row mt-4">
        <div class="col-md-6">
            @if($lawyer->bar_number)
            <p><strong><i class="fas fa-id-card me-2"></i>Bar Number:</strong> {{ $lawyer->bar_number }}</p>
            @endif
            @if($lawyer->license_state)
            <p><strong><i class="fas fa-map me-2"></i>License State:</strong> {{ $lawyer->license_state }}</p>
            @endif
            @if($lawyer->years_of_experience)
            <p><strong><i class="fas fa-briefcase me-2"></i>Years of Experience:</strong> {{ $lawyer->years_of_experience }}+</p>
            @endif
        </div>
        <div class="col-md-6">
            @if($lawyer->firm_name)
            <p><strong><i class="fas fa-building me-2"></i>Firm Name:</strong> {{ $lawyer->firm_name }}</p>
            @endif
            @if($lawyer->website)
            <p><strong><i class="fas fa-globe me-2"></i>Website:</strong>
                <a href="{{ $lawyer->website }}" target="_blank">{{ $lawyer->website }}</a>
            </p>
            @endif
            @if($lawyer->awards)
            <p><strong><i class="fas fa-trophy me-2"></i>Awards:</strong> {{ $lawyer->awards }}</p>
            @endif
        </div>
    </div>
</div>
