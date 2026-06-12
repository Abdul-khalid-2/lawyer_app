<!-- Experience Section -->
@if($lawyer->experiences->count() > 0)
<div class="profile-section">
    <h3 class="section-title">Work Experience</h3>
    @foreach($lawyer->experiences as $experience)
    <div class="timeline-item">
        <h5 class="mb-1">{{ $experience->position }}</h5>
        <p class="text-primary mb-1 fw-bold">{{ $experience->company }}</p>
        <p class="text-muted mb-2">
            {{ $experience->formatted_date }} · {{ $experience->duration }}
        </p>
        @if($experience->description)
        <p class="mb-0">{{ $experience->description }}</p>
        @endif
    </div>
    @endforeach
</div>
@endif
