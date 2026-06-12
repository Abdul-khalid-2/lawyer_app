@props([
    'icon' => 'fas fa-inbox',
    'title' => 'Nothing here yet',
    'message' => null,
    'colspan' => null,   // when used inside a table row
])
@if($colspan)
<tr>
    <td colspan="{{ $colspan }}">
        <div class="d-empty">
            <i class="{{ $icon }} d-empty__icon d-block"></i>
            <h5 class="d-empty__title">{{ $title }}</h5>
            @if($message)<p class="d-empty__message">{{ $message }}</p>@endif
            {{ $slot }}
        </div>
    </td>
</tr>
@else
<div {{ $attributes->merge(['class' => 'd-empty']) }}>
    <i class="{{ $icon }} d-empty__icon d-block"></i>
    <h5 class="d-empty__title">{{ $title }}</h5>
    @if($message)<p class="d-empty__message">{{ $message }}</p>@endif
    {{ $slot }}
</div>
@endif
