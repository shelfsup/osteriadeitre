@extends('layouts.app_layout')

@section('header-script')

@section('content')

    <div class="d-flex flex-wrap gap-5 px-md-4 px-2 mt-3">
        <div class="flex-fill px-3 py-2 d-flex gap-3 flex-column align-items-center justify-content-center" style="background-color: var(--bg-White); border-radius: 18px; box-shadow: var(--shadow-2);">
            <h2 class="m-0">Il Menù</h2>
            <a class="btn btn-primary m-0" style=" box-shadow: var(--shadow-2);" href="{{ route('Il Mio Menù') }}">Gestisci il menù</a>
            {{-- <h5 class="m-0">OPPURE</h5>
            <a class="btn btn-secondary m-0" style=" box-shadow: var(--shadow-2);" href="{{ route('menu_ristorante') }}">Guarda il menù</a> --}}
        </div>

        <div class="flex-fill px-3 py-2 d-flex gap-3 flex-column align-items-center justify-content-center" style="background-color: var(--bg-White); border-radius: 18px; box-shadow: var(--shadow-2);">
            <h2 class="m-0">Gli Special</h2>
            <a class="btn btn-primary m-0" style=" box-shadow: var(--shadow-2);" href="{{ route('Gli Special') }}">Gestisci gli special</a>
            {{-- <h5 class="m-0">OPPURE</h5>
            <a class="btn btn-secondary m-0" style=" box-shadow: var(--shadow-2);" href="{{ route('menu_asporto') }}">Guarda gli special</a> --}}
        </div>
    </div>

    <div class="d-flex flex-wrap gap-5 px-md-4 px-2 mt-5">
        <div class="flex-fill px-3 py-2 d-flex gap-3 flex-column align-items-center justify-content-center" style="background-color: var(--bg-White); border-radius: 18px; box-shadow: var(--shadow-2);">
            <h2 class="m-0">I Menù Online</h2>
            <a class="btn btn-primary m-0" style=" box-shadow: var(--shadow-2);" href="{{ route('menu_ristorante') }}">Modifica i titoli del menù online</a>
            <a class="btn btn-primary m-0" style=" box-shadow: var(--shadow-2);" href="{{ route('menu_asporto_ristorante') }}">Modifica i titoli del menù da asporto online</a>
        </div>
    </div>

    <div>
        @livewire('gestisci-social-network')
    </div>

    <div>
        @livewire('gestisci-sponsor')
    </div>

@endsection

@section('footer-scripts')
@endsection
