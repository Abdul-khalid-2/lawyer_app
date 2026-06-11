<!-- Specializations Section -->
@if($lawyer->specializations->count() > 0)
<div class="profile-section">
    <h3 class="section-title">Areas of Expertise</h3>
    <div class="row">
        @foreach($lawyer->specializations as $specialization)
        <div class="col-md-6 mb-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle p-3 me-3">
                    <i class="{{ $specialization->icon ?? 'fas fa-gavel' }} fa-2x"></i>
                </div>
                <div>
                    <h5 class="mb-0">{{ $specialization->name }}</h5>
                    <p class="mb-0 text-muted">
                        {{ $specialization->pivot->years_of_experience ?? $lawyer->years_of_experience }} years experience
                    </p>
                    @if($specialization->description)
                    <p class="mb-0 small text-muted mt-1">{{ Str::limit($specialization->description, 100) }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
