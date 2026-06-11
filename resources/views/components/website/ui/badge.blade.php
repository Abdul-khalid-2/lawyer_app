@props([
    'variant' => 'neutral',   // neutral | specialization | verified | featured | success | warning | danger
    'icon' => null,
])
<span {{ $attributes->merge(['class' => "lc-badge lc-badge--$variant"]) }}>
    @if($icon)<i class="{{ $icon }}"></i>@endif{{ $slot }}
</span>
