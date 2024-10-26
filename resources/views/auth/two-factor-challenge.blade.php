{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login-post') }}">
                @csrf

                <div class="mt-4" x-show="! recovery">
                    <x-label for="code" value="{{ __('Code') }}" />
                    <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                <div class="mt-4" x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                    <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-cloak
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Use an authentication code') }}
                    </button>

                    <x-button class="ms-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout> --}}

@extends('layouts.guest_layout')

@section('header-script')

@section('content')
    <div class="d-flex align-items-center justify-content-center" style="height: 100%;">

        <x-authentication-card>
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>

            <div x-data="{ recovery: false }">
                <div class="mb-4 fw-bold fs-6" x-show="! recovery">
                    {{ __('Perfavore, completa il login inserendo il codice di autenticazione fornito dall\'applicazione.') }}
                </div>

                <div class="mb-4 fw-bold fs-6" x-cloak x-show="recovery">
                    {{ __('Conferma l\'accesso al tuo account inserendo un codice di recupero.') }}
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('two-factor.login-post') }}">
                    @csrf

                    <div class="mt-4" x-show="! recovery">
                        <x-label for="code" value="{{ __('Codice') }}" />
                        <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                    </div>

                    <div class="mt-4" x-cloak x-show="recovery">
                        <x-label for="recovery_code" value="{{ __('Codice di recupero') }}" />
                        <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                    </div>

                    <div class="d-flex align-items-center justify-content-end mt-4 flex-wrap gap-3">
                        <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" style="border:none; border-radius: 18px; background-color: var(--bg-button-2); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" x-show="! recovery" x-on:click="
                                    recovery = true;
                                    $nextTick(() => { $refs.recovery_code.focus() })
                                " style="text-wrap: nowrap;">
                            {{ __('Usa codice di recupero') }}
                        </button>

                        <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" style="border:none; border-radius: 18px; background-color: var(--bg-button-2); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" x-cloak x-show="recovery" x-on:click="
                                    recovery = false;
                                    $nextTick(() => { $refs.code.focus() })
                                ">
                            {{ __('Usa codice di autenticazione') }}
                        </button>

                        <x-button class="ms-4">
                            {{ __('Accedi') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </x-authentication-card>
    </div>

@endsection

@section('footer-scripts')
@endsection
