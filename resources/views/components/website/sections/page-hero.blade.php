@props([
    'title',
    'subtitle' => null,
    'align' => 'left',   // left | center
    'icon' => null,
])
<section {{ $attributes->merge(['class' => 'lc-page-hero' . ($align === 'center' ? ' lc-page-hero--center' : '')]) }}>
    <div class="container">
        <div class="row {{ $align === 'center' ? 'justify-content-center text-center' : 'align-items-center' }}">
            <div class="col-lg-9">
                @if($icon)
                    <div class="lc-page-hero__icon"><i class="{{ $icon }}"></i></div>
                @endif
                <h1 class="lc-page-hero__title">{{ $title }}</h1>
                @if($subtitle)
                    <p class="lc-page-hero__subtitle">{{ $subtitle }}</p>
                @endif
                @if(trim($slot))
                    <div class="lc-page-hero__actions">{{ $slot }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
