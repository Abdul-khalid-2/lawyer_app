@props([
    'icon',
    'title' => null,
    'number' => null,    // optional step/stat number
])
<div {{ $attributes->merge(['class' => 'lc-icon-box']) }}>
    <div class="lc-icon-box__icon">
        @if($number)<span class="lc-icon-box__number">{{ $number }}</span>@endif
        <i class="{{ $icon }}"></i>
    </div>
    @if($title)
        <h4 class="lc-icon-box__title">{{ $title }}</h4>
    @endif
    @if(trim($slot))
        <p class="lc-icon-box__text">{{ $slot }}</p>
    @endif
</div>
