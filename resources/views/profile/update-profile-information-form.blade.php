<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Informazioni Profilo') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Aggiorna il tuo nome o la tua email.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nome') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4 my-3">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && !$this->user->hasVerifiedEmail())
                <div class="d-flex align-items-center gap-3 flex-wrap mt-3">

                    <p class="fs-6 fw-bold m-0">
                        {{ __('Non hai ancora verificato la tua email!!') }}
                    </p>

                    <button type="button" class="d-flex align-items-center gap-2 px-3 fw-bold fs-6" style="border:none; border-radius: 18px; background-color: var(--bg-button-4); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" wire:click.prevent="sendEmailVerification">
                        {{ __('Clicca qui per ricevere un nuovo link di verifica.') }}
                    </button>
                </div>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 fs-6 fw-semibold">
                        {{ __('Un nuovo link è stato inviato al tuo indirizzo email.') }}
                    </p>
                @endif
            @elseif (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && $this->user->hasVerifiedEmail())
            @endif

        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Salvato.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Salva') }}
        </x-button>
    </x-slot>
</x-form-section>
