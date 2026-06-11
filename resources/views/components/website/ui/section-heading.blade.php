@props([
    'title',
    'subtitle' => null,
    'center' => false,
    'as' => 'h2',
])
<div class="lc-section-heading {{ $center ? 'lc-section-heading--center' : '' }}">
    <{{ $as }} class="lc-section-heading__title">{{ $title }}</{{ $as }}>
    @if($subtitle)
        <p class="lc-section-heading__subtitle">{{ $subtitle }}</p>
    @endif
</div>
