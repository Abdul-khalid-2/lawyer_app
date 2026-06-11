<!-- Education Section -->
@if($lawyer->educations->count() > 0)
<div class="profile-section">
    <h3 class="section-title">Education</h3>
    @foreach($lawyer->educations as $education)
    <div class="timeline-item">
        <h5 class="mb-1">{{ $education->degree }}</h5>
        <p class="text-primary mb-1 fw-bold">{{ $education->institution }}</p>
        <p class="text-muted mb-2">Graduated: {{ $education->graduation_year }}</p>
        @if($education->description)
        <p class="mb-0">{{ $education->description }}</p>
        @endif
    </div>
    @endforeach
</div>
@endif
