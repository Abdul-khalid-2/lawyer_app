@props([
    'label' => null,
    'name',
    'id' => null,
    'rows' => 4,
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
    <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'lc-input lc-textarea' . ($errors->has($name) ? ' is-invalid' : '')]) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="lc-field__error">{{ $message }}</p>
    @enderror
</div>
