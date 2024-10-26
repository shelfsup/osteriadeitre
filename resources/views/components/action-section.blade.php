<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }} >
    <x-section-title >
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="my-3 mx-md-4 mx-2 md:mt-0 md:col-span-2" style="border-radius: 18px;background-color: var(--bg-White)">
        <div class="px-4 py-5 sm:p-6 shadow sm:rounded-lg" style="border-radius: 18px;background-color: var(--bg-White)">
            {{ $content }}
        </div>
    </div>
</div>
