@props([
    'src' => null,
    'alt' => '',
    'ratio' => null,      // e.g. "16x9", "4x3", "1x1" — wraps in fixed-ratio box
    'fallback' => null,   // fallback image url
    'lazy' => true,
])
@php
    $img = $src ?: $fallback;
@endphp
@if($ratio)
    <div class="lc-image lc-image--ratio lc-image--{{ $ratio }}">
        <img src="{{ $img }}" alt="{{ $alt }}"
            @if($lazy) loading="lazy" @endif
            @if($fallback) onerror="this.onerror=null;this.src='{{ $fallback }}'" @endif
            {{ $attributes->merge(['class' => 'lc-image__img']) }}>
    </div>
@else
    <img src="{{ $img }}" alt="{{ $alt }}"
        @if($lazy) loading="lazy" @endif
        @if($fallback) onerror="this.onerror=null;this.src='{{ $fallback }}'" @endif
        {{ $attributes->merge(['class' => 'lc-image']) }}>
@endif
