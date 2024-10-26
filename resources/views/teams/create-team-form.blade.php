<x-form-section submit="createTeam">
    <x-slot name="title">
        {{ __('Nuovo Team') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Crea un nuovo team.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <x-label value="{{ __('Proprietario') }}" />

            <div class="d-flex align-items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" style="border-radius: 50%; object-fit: cover; height: 3rem; width: 3rem;">

                <div class="ms-4 leading-tight" style="line-height: 1.25;">
                    <div class="text-gray-900">{{ $this->user->name }}</div>
                    <div class="text-gray-700 text-sm">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nome Team') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button>
            {{ __('Crea') }}
        </x-button>
    </x-slot>
</x-form-section>
