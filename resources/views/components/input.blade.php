@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'fw-medium fs-6 px-3 py-1', 'style' => 'border:none; border-radius: 18px; color: var(--color-text);']) !!}>
