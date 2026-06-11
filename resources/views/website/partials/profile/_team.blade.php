<!-- Team Section -->
@php
    $activeTeamMembers = $lawyer->teamMembers()->where('is_active', true)->orderBy('order')->orderBy('name')->get();
@endphp
@if($activeTeamMembers->count() > 0)
<div class="profile-section">
    <h3 class="section-title">Our Team</h3>
    <div class="row">
        @foreach($activeTeamMembers as $member)
            <x-website.cards.team-member-card :member="$member" />
        @endforeach
    </div>
</div>
@endif
