@props(['member'])
<div class="col-md-6 col-lg-4 mb-3">
    <div class="lc-card lc-team-card text-center">
        <div class="lc-card__body">
            <x-website.ui.avatar :src="$member->photo_url" :name="$member->name" size="lg" class="mx-auto mb-3" />
            <h5 class="mb-1">{{ $member->name }}</h5>
            <p class="text-primary fw-bold mb-1">{{ $member->designation }}</p>
            @if($member->qualifications)
                <p class="small text-muted mb-1">{{ $member->qualifications }}</p>
            @endif
            @if($member->years_of_experience)
                <p class="small text-muted mb-0">{{ $member->years_of_experience }}+ years experience</p>
            @endif
        </div>
    </div>
</div>
