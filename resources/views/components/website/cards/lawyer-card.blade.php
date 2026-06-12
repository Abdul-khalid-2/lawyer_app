@props(['lawyer'])
@php
    $averageRating = $lawyer->reviews->avg('rating');
    $reviewCount = $lawyer->reviews->count();
    $photo = $lawyer->user->profile_image
        ? asset('website/' . $lawyer->user->profile_image)
        : asset('website/images/male_advocate_avatar.jpg');
@endphp
<div class="col-12 col-md-6 col-xl-4 mb-4">
    <div class="lc-card lc-lawyer-card {{ $lawyer->is_featured ? 'lc-lawyer-card--featured' : '' }}">
        <div class="lc-lawyer-card__media">
            <x-website.ui.image :src="$photo" :alt="$lawyer->user->name"
                ratio="3x2" :fallback="asset('website/images/male_advocate_avatar.jpg')"
                class="lc-lawyer-card__photo" />
            @if($lawyer->is_featured)
                <span class="lc-lawyer-card__featured"><i class="fas fa-star"></i> Featured</span>
            @endif
        </div>

        <div class="lc-card__body">
            <div class="d-flex align-items-start mb-2">
                <div class="flex-grow-1">
                    <h6 class="lc-lawyer-card__name mb-1">{{ $lawyer->user->name }}</h6>
                    <p class="lc-lawyer-card__meta mb-1">
                        <i class="fas fa-briefcase me-1"></i>{{ $lawyer->years_of_experience }}+ years experience
                    </p>
                    @if($lawyer->city || $lawyer->state)
                        <p class="lc-lawyer-card__meta lc-lawyer-card__meta--muted mb-0">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $lawyer->city }}{{ $lawyer->city && $lawyer->state ? ', ' : '' }}{{ $lawyer->state }}
                        </p>
                    @endif
                </div>
            </div>

            @if($lawyer->specializations->count() > 0)
                <div class="d-flex flex-wrap gap-1 mb-3">
                    @foreach($lawyer->specializations->take(2) as $specialization)
                        <x-website.ui.badge variant="neutral">{{ $specialization->name }}</x-website.ui.badge>
                    @endforeach
                    @if($lawyer->specializations->count() > 2)
                        <x-website.ui.badge variant="neutral">+{{ $lawyer->specializations->count() - 2 }} more</x-website.ui.badge>
                    @endif
                </div>
            @endif

            <div class="mb-3">
                <x-website.ui.rating :value="$averageRating ?? 0" :count="$reviewCount" />
            </div>

            @if($lawyer->bio)
                <div class="mb-3 flex-grow-1">
                    <p class="lc-lawyer-card__bio mb-0">{{ Str::limit(strip_tags($lawyer->bio), 120) }}</p>
                </div>
            @endif

            <div class="lc-card__footer">
                <div class="d-grid gap-2">
                    <x-website.ui.button :href="route('website.lawyers.profile', $lawyer->uuid)"
                        variant="primary" size="sm" icon="fas fa-user-circle">View Profile</x-website.ui.button>
                    @if($lawyer->user->phone)
                        <div class="d-flex gap-2">
                            <x-website.ui.button :href="'tel:' . $lawyer->user->phone"
                                variant="success" size="sm" icon="fas fa-phone" class="flex-fill">Call</x-website.ui.button>
                            <x-website.ui.button :href="'https://wa.me/' . $lawyer->user->phone"
                                variant="success" size="sm" icon="fab fa-whatsapp" target="_blank" aria-label="WhatsApp" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
