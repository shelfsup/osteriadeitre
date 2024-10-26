@extends('layouts.guest_layout')

@section('header-script')
@endsection

@section('content')
<div class="w-100 d-flex justify-content-center align-items-center" style="height: 100%;">
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 fs-6 fw-semibold text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
            </div>

            <div class="mb-3 form-check">
                <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
                <label class="form-check-label fw-bold" for="remember_me">{{ __('Ricordami') }}</label>
            </div>

            <div class="d-flex justify-content-end mb-3">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none me-4 fw-bold " style="color: rgba(0, 0, 0, 0.33);">{{ __('Dimenticato la password?') }}</a>
                @endif

                <button type="submit" class="btn-custom px-4  fw-bold">{{ __('Accedi') }}</button>
            </div>
        </form>
    </x-authentication-card>
</div>
@endsection

@section('footer-scripts')
@endsection
