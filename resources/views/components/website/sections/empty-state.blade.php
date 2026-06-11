@props([
    'icon' => 'fas fa-inbox',
    'title' => 'Nothing here yet',
    'message' => null,
])
<div {{ $attributes->merge(['class' => 'lc-empty-state']) }}>
    <i class="{{ $icon }} lc-empty-state__icon"></i>
    <h5 class="lc-empty-state__title">{{ $title }}</h5>
    @if($message)
        <p class="lc-empty-state__message">{{ $message }}</p>
    @endif
    {{ $slot }}
</div>
