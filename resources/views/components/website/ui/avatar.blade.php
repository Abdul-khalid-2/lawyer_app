@props([
    'src' => null,
    'name' => '',
    'size' => 'md',   // sm | md | lg | xl
    'alt' => null,
])
@php
    $initials = collect(explode(' ', trim($name)))
        ->filter()
        ->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
        ->implode('');
@endphp
@if($src)
    <img src="{{ $src }}" alt="{{ $alt ?? $name }}"
        {{ $attributes->merge(['class' => "lc-avatar lc-avatar--$size", 'loading' => 'lazy']) }}>
@else
    <span {{ $attributes->merge(['class' => "lc-avatar lc-avatar--$size lc-avatar--initials"]) }}
        role="img" aria-label="{{ $alt ?? $name }}">{{ $initials ?: '?' }}</span>
@endif
