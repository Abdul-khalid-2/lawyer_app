<!-- Availability Section -->
@php
    $publicSlots = $lawyer->schedules()->where('is_public', true)
        ->where('start_datetime', '>=', now())
        ->orderBy('start_datetime')->limit(6)->get();
@endphp
@if($publicSlots->count() > 0)
<div class="profile-section" id="availability">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h3 class="section-title mb-0 border-0 pb-0">Upcoming Availability</h3>
        <x-website.ui.button variant="primary" size="sm" icon="fas fa-calendar-check"
            data-bs-toggle="modal" data-bs-target="#scheduleModal">Schedule Consultation</x-website.ui.button>
    </div>
    <div class="row">
        @foreach($publicSlots as $slot)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check text-success fa-2x mb-2"></i>
                    <h6 class="mb-1">{{ $slot->start_datetime->format('D, d M Y') }}</h6>
                    <p class="text-muted mb-0">
                        {{ $slot->start_datetime->format('h:i A') }} – {{ $slot->end_datetime->format('h:i A') }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <p class="small text-muted mb-0">Contact the lawyer to book a consultation during these slots.</p>
</div>
@endif
