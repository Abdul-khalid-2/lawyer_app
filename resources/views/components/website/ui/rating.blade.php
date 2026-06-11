@props([
    'value' => 0,        // average rating 0..5
    'count' => null,     // number of reviews (optional)
    'showValue' => true,
])
@php
    $value = (float) $value;
    $count = $count !== null ? (int) $count : null;
@endphp
<span {{ $attributes->merge(['class' => 'lc-rating']) }}>
    <span class="lc-rating__stars" aria-hidden="true">
        @for($i = 1; $i <= 5; $i++)
            @if($i <= floor($value))
                <i class="fas fa-star"></i>
            @elseif($i - 0.5 <= $value)
                <i class="fas fa-star-half-alt"></i>
            @else
                <i class="far fa-star"></i>
            @endif
        @endfor
    </span>
    @if($showValue && $count !== null && $count > 0)
        <span class="lc-rating__value">{{ number_format($value, 1) }} ({{ $count }} {{ Str::plural('review', $count) }})</span>
    @elseif($count === 0)
        <span class="lc-rating__value lc-rating__value--empty">No reviews yet</span>
    @endif
</span>
