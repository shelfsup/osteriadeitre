<div class="mb-4">

    <div class="mb-3 ms-2">
        <div class="dropdown">
            <button class="btn btn-secondary" type="button" style="box-shadow: var(--shadow-2);" data-bs-toggle="dropdown" aria-expanded="false">
                @if ($selectedLanguage == 'it')
                    Change Language
                @else
                    Cambia Lingua
                @endif
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a onclick="Livewire.dispatch('switchLanguage', ['it'])" class="dropdown-item" href="#">
                        <div class="d-flex align-items-center gap-2">
                            <div style="background-image: url('/svg/bandiera_italiana.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center;"></div>
                            <p class="m-0">Italiano</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a onclick="Livewire.dispatch('switchLanguage', ['en'])" class="dropdown-item" href="#">
                        <div class="d-flex align-items-center gap-2">
                            <div style="background-image: url('/svg/bandiera_inglese.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center;"></div>
                            <p class="m-0">English</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="d-flex justify-content-center flex-column align-items-center mt-1" style="height: 30vh">
        <div id="immagine_logo_caricamento" style="background-image: var(--background-image-logo);"></div>
    </div>

    <div class="my-4 mx-md-5 mx-2 p-3 background2-sezione-aperitivi" style="background-image: var(--background2-sezione-aperitivi);">
        <div class="py-5 background-sezione-aperitivi" style="background-image: var(--background-sezione-aperitivi);">
            @if (Auth::user())
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div style="position: relative; width:fit-content; height: fit-content;">
                        <h1 class="text-center aperitivo-testo-titolo  mb-0 testo-titolo" wire:model.live=@if ($this->selectedLanguage == 'it') "titolo_ita" @else "titolo_eng" @endif>
                            {{ $this->selectedLanguage == 'it' ? $titolo_ita : $titolo_eng }}
                        </h1>
                        <button wire:click="toggleTitolo" style="position: absolute; top: 0; right: -2rem; border:none; background-color: var(--bg-None);"><i class="bi bi-pencil-fill"></i></button>
                    </div>
                    @if ($this->modifyTitolo)
                        <div class="d-flex gap-2 justify-content-center mb-4">
                            <input type="text" wire:model.live=@if ($this->selectedLanguage == 'it') "titolo_ita" @else "titolo_eng" @endif id="">
                            <button wire:click="saveTitoli" style="font-size: 1.5rem; border:none; background-color: var(--bg-None);" class="text-success"><i class="bi bi-check-circle"></i></button>
                            <button wire:click="setTitoli" style="font-size: 1.5rem; border:none; background-color: var(--bg-None);" class="text-danger"><i class="bi bi-x-circle"></i></button>
                        </div>
                    @endif

                    <div style="position: relative">
                        <p wire:model.live=@if ($this->selectedLanguage == 'it') "sottotitolo_ita" @else "sottotitolo_eng" @endif class="text-center aperitivo-testo-sottotitolo fs-6 testo-sottotitolo">
                            {{ $this->selectedLanguage == 'it' ? $sottotitolo_ita : $sottotitolo_eng }}
                        </p>
                        <button wire:click="toggleSottotitolo" style="position: absolute; top: 0; right: -2rem; border:none; background-color: var(--bg-None);"><i class="bi bi-pencil-fill"></i></button>
                    </div>
                    @if ($this->modifySottotitolo)
                        <div class="d-flex gap-2 justify-content-center mb-4">
                            <input type="text" wire:model.live=@if ($this->selectedLanguage == 'it') "sottotitolo_ita" @else "sottotitolo_eng" @endif id="">
                            <button wire:click="saveTitoli" style="font-size: 1.5rem; border:none; background-color: var(--bg-None);" class="text-success"><i class="bi bi-check-circle"></i></button>
                            <button wire:click="setTitoli" style="font-size: 1.5rem; border:none; background-color: var(--bg-None);" class="text-danger"><i class="bi bi-x-circle"></i></button>
                        </div>
                    @endif
                </div>
            @else
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div style="position: relative; width:fit-content; height: fit-content;">
                        <h1 class="text-center  mb-0 testo-titolo">
                            {{ $this->selectedLanguage == 'it' ? $titolo_ita : $titolo_eng }}
                        </h1>
                    </div>

                    <div style="position: relative">
                        <p class="text-center fs-6 testo-sottotitolo">
                            {{ $this->selectedLanguage == 'it' ? $sottotitolo_ita : $sottotitolo_eng }}
                        </p>
                    </div>

                </div>
            @endif


            @if (count($piatti) > 2)
                @if ($piatti->isNotEmpty())

                    <div class="px-3 pb-3 mb-5 mx-2">
                        <div wire:ignore class="swiper-container">
                            <style>
                                .swiper-container {
                                    width: 100%;
                                    height: fit-content;
                                    position: relative;
                                }

                                .swiper-container {
                                    width: 100%;
                                    height: fit-content;
                                    overflow: hidden;
                                    position: relative;
                                }

                                .swiper-slide {
                                    background-color: #ffffff00;
                                    height: fit-content;
                                }

                                .swiper-button-next,
                                .swiper-button-prev {
                                    color: #fff;
                                }

                                .swiper-pagination {
                                    bottom: 10px;
                                    left: 0;
                                    width: 100%;
                                    text-align: center;
                                    color: #fff;
                                }

                                .swiper-pagination-bullet {
                                    background: #fff;
                                }
                            </style>
                            <div class="swiper-wrapper">
                                @foreach ($piatti as $piatto)
                                    <div class="swiper-slide">
                                        <div class="d-flex flex-column gap-2 align-items-center justify-content-start pt-2">


                                            <div class="aperitivo-contenitore">
                                                <p style=" font-size: calc(1.75rem + 1.2vw) !important;" class="fs-1 fw-bold px-2 aperitivo-prezzo m-0" style="color: #fff !important;">
                                                    @if (fmod($piatto->prezzo, 1) == 0)
                                                        {{ number_format($piatto->prezzo, 0, ',', '.') }}€
                                                    @else
                                                        {{ number_format($piatto->prezzo, 2, ',', '.') }}€
                                                    @endif
                                                </p>
                                            </div>

                                            <div>
                                                <h2 class="text-center aperitivo-testo px-2 m-0" style="color: #fff !important;">{!! $piatto->nome($selectedLanguage) !!} @if ($piatto->surgelato) <i class="bi bi-snow2" style="font-size: 0.5rem; vertical-align: super;"></i> @endif</h2>
                                                <p class="text-center aperitivo-descrizione fs-7 mx-5 px-2 my-3" style="color: #fff !important;">{!! $piatto->descrizione($selectedLanguage) !!}</p>
                                            </div>

                                            <div class="d-flex flex-column w-100 mb-5">
                                                @php
                                                    $allergeni = json_decode($piatto->allergeni) ?? null;
                                                @endphp
                                                @if ($allergeni)
                                                    <div class="d-flex flex-wrap justify-content-center">
                                                        @foreach ($allergeni as $allergene)
                                                            @php
                                                                $allergene = \App\Models\Allergeni::findOrFail($allergene);
                                                            @endphp
                                                            <button data-bs-toggle="modal" data-bs-target="#allergeniModal" class="invert-image m-1" style="filter: invert(100%); -webkit-filter: invert(100%); background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center; border: none; background-color: var(--bg-None);"></button>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                @endif
            @else
                <div class="d-flex justify-content-evenly">
                    @foreach ($piatti as $piatto)
                        <div class="d-flex flex-column gap-2 align-items-center justify-content-start pt-2">
                            <div class="aperitivo-contenitore">
                                <p style=" font-size: calc(1.75rem + 1.2vw) !important;" class="fs-1 fw-bold px-2 aperitivo-prezzo m-0" style="color: #fff !important;">
                                    @if (fmod($piatto->prezzo, 1) == 0)
                                        {{ number_format($piatto->prezzo, 0, ',', '.') }}€
                                    @else
                                        {{ number_format($piatto->prezzo, 2, ',', '.') }}€
                                    @endif
                                </p>
                            </div>

                            <div>
                                <h2 class="text-center aperitivo-testo px-2 m-0" style="color: #fff !important;">{!! $piatto->nome($selectedLanguage) !!} @if ($piatto->surgelato) <i class="bi bi-snow2" style="font-size: 0.5rem; vertical-align: super;"></i> @endif</h2>
                                <p class="text-center aperitivo-descrizione fs-7 px-2 m-0" style="color: #fff !important;">{!! $piatto->descrizione($selectedLanguage) !!}</p>
                            </div>

                            <div class="d-flex flex-column w-100">
                                @php
                                    $allergeni = json_decode($piatto->allergeni) ?? null;
                                @endphp
                                @if ($allergeni)
                                    <div class="d-flex flex-wrap justify-content-center">
                                        @foreach ($allergeni as $allergene)
                                            @php
                                                $allergene = \App\Models\Allergeni::findOrFail($allergene);
                                            @endphp
                                            {{-- <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $allergene->nome($selectedLanguage) }}" class="invert-image m-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center;"></div> --}}
                                            <button data-bs-toggle="modal" data-bs-target="#allergeniModal" class="invert-image m-1" style="filter: invert(100%); -webkit-filter: invert(100%); background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center; border: none; background-color: var(--bg-None);"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    @if (count($piatti) > 2)
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                initializeSwiper();


                Livewire.on('resetCarousel', (event) => {
                    setTimeout(() => {
                        initializeSwiper();
                    }, 15);
                });

                function initializeSwiper() {
                    if (window.swiper) {
                        window.swiper.destroy();
                    }
                    window.swiper = new Swiper('.swiper-container', {
                        // loop: true,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        autoplay: {
                            delay: 3500,
                            disableOnInteraction: false,
                        },
                    });
                }

            });
        </script>
    @endif

@endpush
