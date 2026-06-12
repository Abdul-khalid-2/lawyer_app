@props([
    'label',
    'value',
    'icon' => 'fas fa-chart-bar',
    'variant' => 'primary',   // primary | success | warning | danger | info | secondary
])
<div {{ $attributes->merge(['class' => 'd-stat']) }}>
    <div>
        <p class="d-stat__label">{{ $label }}</p>
        <p class="d-stat__value">{{ $value }}</p>
    </div>
    <span class="d-stat__icon d-stat__icon--{{ $variant }}">
        <i class="{{ $icon }}"></i>
    </span>
</div>
