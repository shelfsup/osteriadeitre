@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700', 'style' => ' color: var(--color-text);']) }}>
    {{ $value ?? $slot }}
</label>
