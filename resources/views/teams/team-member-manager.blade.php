<div>
    @if (Gate::check('addTeamMember', $team))
        <x-section-border />

        <!-- Add Team Member -->
        <div class="mt-10 sm:mt-0">
            <x-form-section submit="addTeamMember">
                <x-slot name="title">
                    {{ __('Aggiungi un membro') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Invita membri a far parte di questo Team e fatti aiutare nella gestione della casa!') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            {{ __('Inserisci la mail da invitare nel Team.') }}
                        </div>
                    </div>

                    <!-- Member Email -->
                    <div class="col-span-6 sm:col-span-4 my-2">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" type="email" class="mt-1 block w-full" wire:model="addTeamMemberForm.email" />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    <!-- Role -->
                    @if (count($this->roles) > 0)
                        <div class="col-span-6 lg:col-span-4">
                            <x-label for="role" :value="__('Ruoli')" />
                            <x-input-error for="role" class="mt-2" />

                            <div class="list-group mt-1">
                                @foreach ($this->roles as $index => $role)
                                    <button type="button" class="list-group-item list-group-item-action {{ $index > 0 ? 'border-top-0' : '' }}" wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')" style="background-color: var(--bg-White); color: var(--color-text) !important;">
                                        <div class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                            <!-- Role Name -->
                                            <div class="d-flex align-items-center">
                                                <div class="text-sm text-gray-600 {{ $addTeamMemberForm['role'] == $role->key ? 'fw-bold' : 'fw-semibold' }}">
                                                    {{ $role->name }}
                                                </div>

                                                @if ($addTeamMemberForm['role'] == $role->key)
                                                    <svg class="ms-2 h-5 w-5 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 1.25rem; width: 1.25rem;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </div>

                                            <!-- Role Description -->
                                            <div class="mt-2 text-xs text-gray-600">
                                                {{ $role->description }}
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </x-slot>

                <x-slot name="actions">
                    <x-action-message class="me-3" on="saved">
                        {{ __('Aggiunto.') }}
                    </x-action-message>

                    <x-button>
                        {{ __('Aggiungi') }}
                    </x-button>
                </x-slot>
            </x-form-section>
        </div>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
        <x-section-border />

        <!-- Team Member Invitations -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __('Inviti in attesa di conferma') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Queste persone sono state invitate a far parte di o Team. Dovrebbero aver ricevuto un invito via email..') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->teamInvitations as $invitation)
                            <div class="d-flex align-items-center gap-2">
                                <div class="text-gray-600">{{ $invitation->email }}</div>

                                <div class="d-flex align-items-center">
                                    @if (Gate::check('removeTeamMember', $team))
                                        <!-- Cancel Team Invitation -->
                                        <button wire:click="cancelTeamInvitation({{ $invitation->id }})" class="d-flex align-items-center gap-2 px-3 fw-bold fs-6 ms-2" style="border:none; border-radius: 18px; background-color: var(--bg-button-3); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                                            {{ __('Cancella') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    @if ($team->users->isNotEmpty())
        <x-section-border />

        <!-- Manage Team Members -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __('Membri del Team') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Tutte le persone che fanno parte di questo Team.') }}
                </x-slot>

                <!-- Team Member List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->users->sortBy('name') as $user)
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" style="border-radius:50%; height: 2rem; width: 2rem; object-fit: cover;">
                                    <div class="ms-2">{{ $user->name }}</div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <!-- Manage Team Member Role -->
                                    @if (Gate::check('updateTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                        <button wire:click="manageRole('{{ $user->id }}')" class="d-flex align-items-center gap-2 px-3 fw-bold fs-6 ms-2" style="border:none; border-radius: 18px; background-color: var(--bg-button-2); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; color: var(--color-text) !important;">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                        </button>
                                    @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                        <div class="d-flex align-items-center gap-2 px-3 fw-bold fs-6 ms-2" style="border:none; border-radius: 18px; background-color: var(--bg-button-2); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                        </div>
                                    @endif

                                    <!-- Leave Team -->
                                    @if ($this->user->id === $user->id)
                                        <button wire:click="$toggle('confirmingLeavingTeam')" class="d-flex align-items-center gap-2 px-3 fw-bold fs-6 ms-2" style="border:none; border-radius: 18px; background-color: var(--bg-button-3); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; color: var(--color-text) !important;">
                                            {{ __('Lascia') }}
                                        </button>

                                        <!-- Remove Team Member -->
                                    @elseif (Gate::check('removeTeamMember', $team))
                                        <button wire:click="confirmTeamMemberRemoval('{{ $user->id }}')" class="d-flex align-items-center gap-2 px-3 fw-bold fs-6 ms-2" style="border:none; border-radius: 18px; background-color: var(--bg-button-3); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; color: var(--color-text) !important;">
                                            {{ __('Rimuovi') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <!-- Role Management Modal -->
    <x-dialog-modal wire:model.live="currentlyManagingRole">
        <x-slot name="title">
            {{ __('Seleziona il ruolo') }}
        </x-slot>

        <x-slot name="content">
            <div class="list-group mt-1">
                @foreach ($this->roles as $index => $role)
                    <button type="button" class="list-group-item list-group-item-action {{ $index > 0 ? 'border-top-0' : '' }}" wire:click="$set('currentRole', '{{ $role->key }}')" style="background-color: var(--bg-White); color: var(--color-text) !important;">
                        <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                            <!-- Role Name -->
                            <div class="d-flex align-items-center">
                                <div class="fs-6 {{ $currentRole == $role->key ? 'fw-bold' : 'fw-semibold' }} text-gray-600">
                                    {{ $role->name }}
                                </div>

                                @if ($currentRole == $role->key)
                                    <svg class="ms-2 h-5 w-5 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 1.25rem; width: 1.25rem;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Role Description -->
                            <div class="mt-2 text-xs text-gray-600">
                                {{ $role->description }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-slot>


        <x-slot name="footer">
            <x-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ __('Cancella') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="updateRole" wire:loading.attr="disabled">
                {{ __('Salva') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Leave Team Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingLeavingTeam">
        <x-slot name="title">
            {{ __('Lascia Team') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Sei sicuro di voler abbandonare questo Team?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="leaveTeam" wire:loading.attr="disabled">
                {{ __('Lascia') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Remove Team Member Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('Rimuovi il membro') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Sei suciro di voler rimuovere questo membro dal Team?') }}
            <div class="d-flex align-items-center justify-content-center mt-3">
                <x-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                    {{ __('Cancella') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="removeTeamMember" wire:loading.attr="disabled">
                    {{ __('Rimuovi') }}
                </x-danger-button>
            </div>
        </x-slot>

        <x-slot name="footer" style="d-flex align-items-center">

        </x-slot>
    </x-confirmation-modal>
</div>
