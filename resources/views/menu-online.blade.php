@extends('layouts.menu_layout')

@section('content')
    <div class="mt-5">
        @livewire('carousel-fuori-menu')
    </div>

    <div class="mb-5">
        <div class="px-md-4 px-2 mb-5">
            <div class="col-12">
                @livewire('menu-online')
            </div>
        </div>
    </div>
@endsection
