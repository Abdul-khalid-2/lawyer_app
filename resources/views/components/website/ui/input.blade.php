@props([
    'label' => null,
    'name',
    'id' => null,
    'type' => 'text',
    'icon' => null,
    'value' => null,
    'required' => false,
    'placeholder' => null,
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
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
            value="{{ old($name, $value) }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            {{ $attributes->merge(['class' => 'lc-input' . ($errors->has($name) ? ' is-invalid' : '')]) }}>
    </div>
    @error($name)
        <p class="lc-field__error">{{ $message }}</p>
    @enderror
</div>
