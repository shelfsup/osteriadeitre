<button {{ $attributes->merge(['type' => 'button', 'class' => 'd-flex align-items-center gap-2 px-3 fw-bold fs-6', 'style' => 'border:none; border-radius: 18px; background-color: var(--bg-button-3); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; color: var(--color-text) !important;']) }}>
    {{ $slot }}
</button>
