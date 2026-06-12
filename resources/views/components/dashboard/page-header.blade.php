@props([
    'title',
    'subtitle' => null,
    'icon' => null,
])
<div {{ $attributes->merge(['class' => 'd-page-header']) }}>
    <div class="d-page-header__titles">
        @if($icon)
            <span class="d-page-header__icon"><i class="{{ $icon }}"></i></span>
        @endif
        <div>
            <h1 class="d-page-header__title">{{ $title }}</h1>
            @if($subtitle)
                <p class="d-page-header__subtitle">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
    @if(trim($slot))
        <div class="d-page-header__actions">{{ $slot }}</div>
    @endif
</div>
