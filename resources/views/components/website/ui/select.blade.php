@props([
    'label' => null,
    'name',
    'id' => null,
    'icon' => null,
    'required' => false,
])
@php $id = $id ?? $name; @endphp
<div class="lc-field">
    @if($label)
        <label for="{{ $id }}" class="lc-field__label">
            {{ $label }}@if($required)<span class="lc-field__req">*</span>@endif
        </label>
    @endif
    <div class="lc-field__control {{ $icon ? 'lc-field__control--icon' : '' }}">
        @if($icon)<i class="{{ $icon }} lc-field__icon"></i>@endif
        <select name="{{ $name }}" id="{{ $id }}"
            @if($required) required @endif
            {{ $attributes->merge(['class' => 'lc-input lc-select' . ($errors->has($name) ? ' is-invalid' : '')]) }}>
            {{ $slot }}
        </select>
    </div>
    @error($name)
        <p class="lc-field__error">{{ $message }}</p>
    @enderror
</div>
