@php
    $modalSlots = $lawyer->schedules()->where('is_public', true)
        ->where('start_datetime', '>=', now())
        ->orderBy('start_datetime')->limit(12)->get();
@endphp
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">
                    <i class="fas fa-calendar-check text-success me-2"></i>
                    Schedule a Consultation with {{ $lawyer->user->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($modalSlots->count() > 0)
                    <p class="text-muted">Pick one of the lawyer's upcoming available slots, then reach out to confirm your booking.</p>
                    <div class="row g-3">
                        @foreach($modalSlots as $slot)
                        <div class="col-md-6">
                            <div class="lc-slot">
                                <div class="lc-slot__date">
                                    <i class="far fa-calendar me-2 text-success"></i>{{ $slot->start_datetime->format('l, d M Y') }}
                                </div>
                                <div class="lc-slot__time">
                                    <i class="far fa-clock me-2"></i>{{ $slot->start_datetime->format('h:i A') }} – {{ $slot->end_datetime->format('h:i A') }}
                                </div>
                                @if($slot->location)
                                <div class="lc-slot__loc"><i class="fas fa-map-marker-alt me-2"></i>{{ $slot->location }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="far fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h6>No published slots right now</h6>
                        <p class="text-muted mb-0">Reach out directly and {{ $lawyer->user->name }} will arrange a consultation time that works for you.</p>
                    </div>
                @endif

                <hr class="my-4">
                <h6 class="fw-bold mb-3">Contact to confirm</h6>
                <div class="d-flex flex-wrap gap-2">
                    @if($lawyer->phone)
                    <x-website.ui.button :href="'tel:' . $lawyer->phone" variant="success" size="sm" icon="fas fa-phone">Call</x-website.ui.button>
                    <x-website.ui.button :href="'https://wa.me/' . preg_replace('/[^0-9]/', '', $lawyer->phone)" variant="success" size="sm" icon="fab fa-whatsapp" target="_blank">WhatsApp</x-website.ui.button>
                    @endif
                    <x-website.ui.button :href="'mailto:' . $lawyer->user->email . '?subject=' . rawurlencode('Consultation request')" variant="primary" size="sm" icon="fas fa-envelope">Email</x-website.ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
