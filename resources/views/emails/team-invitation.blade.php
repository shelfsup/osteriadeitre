@component('mail::message')
{{ __('Sei stato invitato a far parte del team :team !', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('Se non sei registrato crea prima un\account e poi torna qui e clicca su accetta invito:') }}

@component('mail::button', ['url' => route('register')])
{{ __('Crea Account') }}
@endcomponent

{{ __('If you already have an account, you may accept this invitation by clicking the button below:') }}

@else
{{ __('Accetta l\'invito cliccando sul bottone di seguito:') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('Accetta Invito') }}
@endcomponent

{{ __('Se hai ricevuto questa email per errore, ignorala.') }}
@endcomponent
