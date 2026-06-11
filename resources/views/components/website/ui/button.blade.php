@props([
    'variant' => 'primary',   // primary | outline | accent | ghost | danger | success
    'size' => 'md',           // sm | md | lg
    'href' => null,           // renders <a> when set, else <button>
    'icon' => null,           // font-awesome class, e.g. "fas fa-search"
    'iconRight' => false,     // place icon after the label
    'type' => 'button',
])
@php
    $classes = "lc-btn lc-btn--$variant lc-btn--$size";
@endphp
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && !$iconRight)<i class="{{ $icon }} lc-btn__icon"></i>@endif
        {{ $slot }}
        @if($icon && $iconRight)<i class="{{ $icon }} lc-btn__icon lc-btn__icon--right"></i>@endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && !$iconRight)<i class="{{ $icon }} lc-btn__icon"></i>@endif
        {{ $slot }}
        @if($icon && $iconRight)<i class="{{ $icon }} lc-btn__icon lc-btn__icon--right"></i>@endif
    </button>
@endif
