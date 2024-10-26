<div>
    <style>
        .accordion-custom-menu .accordion-button::after {
            display: none !important;
        }

        .ul-menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .li-menu {
            padding: 10px 0;
        }


        /* .piatto-nome {
            font-weight: 700;
            margin: 0;
            background: linear-gradient(90deg, #D9D9D9 0%, #ffeed5 70.5%, #FDBE61 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

        } */

        /* .piatto-prezzo {
            background: linear-gradient(90deg, #D9D9D9 0%, #ffeed5 70.5%, #FDBE61 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        } */

        .piatto-descrizione {
            font-size: 0.9em;
            font-weight: 700;
            margin: 0;
        }

        .allergene-icon {
            height: 0.9rem;
            width: 0.9rem;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            border: none;
            background-color: transparent;
        }

        .dotted-circle-hr {
            border: none;
            border-top: 3px dotted;
            border-color: transparent;
            background-image: radial-gradient(circle, black 1px, transparent 1px);
            background-size: 10px 10px;
            background-position: center;
            height: 5px;
            margin: 0;
        }

        li:hover {
            border-radius: 0 !important;
        }

        td {
            border: none !important;
            border-bottom: 1px solid var(--bg-lightgreen) !important;
        }

        .modal-title {
            color: rgb(255, 255, 255) !important;
        }

        .modal-body {
            color: black !important;
        }

        .modal-content {
            background-color: var(--bg-modal-content) !important;
        }

        .modal-content hr {
            color: black !important;
            border: none;
            border-bottom: 4px dotted black !important;
            opacity: 0.5 !important;
        }
    </style>

    @if (Auth::user())
        <div class="d-flex flex-column align-items-center justify-content-center mb-3">
            <div style="position: relative; width:fit-content; height: fit-content;">
                <h1 class="text-center  mb-0 testo-titolo" wire:model.live=@if ($this->selectedLanguage == 'it') "titolo_menu_ita" @else "titolo_menu_eng" @endif>
                    {{ $this->selectedLanguage == 'it' ? $titolo_menu_ita : $titolo_menu_eng }}
                </h1>
                <button wire:click="toggleTitoloMenu" style="position: absolute; top: 0; right: -2rem; border:none; background-color: var(--bg-None);"><i class="bi bi-pencil-fill"></i></button>
            </div>
            @if ($this->modifyTitoloMenu)
                <div class="d-flex gap-2 justify-content-center mb-4">
                    <input type="text" wire:model.live=@if ($this->selectedLanguage == 'it') "titolo_menu_ita" @else "titolo_menu_eng" @endif id="">
                    <button wire:click="saveTitoli" style="font-size: 1.5rem; border:none; background-color: var(--bg-None);" class="text-success"><i class="bi bi-check-circle"></i></button>
                    <button wire:click="setTitoli" style="font-size: 1.5rem; border:none; background-color: var(--bg-None);" class="text-danger"><i class="bi bi-x-circle"></i></button>
                </div>
            @endif
        </div>
    @else
        <div class="d-flex flex-column align-items-center justify-content-center mb-3">
            <div style="position: relative; width:fit-content; height: fit-content;">
                <h1 class="text-center  mb-0 testo-titolo">
                    {{ $this->selectedLanguage == 'it' ? $titolo_menu_ita : $titolo_menu_eng }}
                </h1>
            </div>
        </div>
    @endif

    <div class="accordion" id="menuAccordion">
        @foreach ($categorie as $categoria)
            <div class="accordion-item" x-data="{ open: false }">
                <h2 class="accordion-header d-flex accordion-custom-menu" id="heading{{ $categoria->id }}">
                    <button class="accordion-button fs-3" :class="{ 'collapsed': !open }" type="button" @click="open = !open" data-bs-toggle="collapse" data-bs-target="#collapse{{ $categoria->id }}" aria-expanded="true" aria-controls="collapse{{ $categoria->id }}">
                        {!! $categoria->nome($selectedLanguage) !!}
                    </button>
                </h2>
                <div style=" border-radius: 12px;  background-size: cover; background-blend-mode: multiply;" id="collapse{{ $categoria->id }}" class="accordion-collapse collapse" :class="{ 'show': open }" aria-labelledby="heading{{ $categoria->id }}" data-bs-parent="#menuAccordion">
                    <div class="accordion-body">
                        @foreach ($categoria->piatti as $piatto)
                            <div class=" py-2 tabella-piatto" style="border-bottom: 1px solid var(--bg-border-bottom-piatto);" data-lingua="{{ $selectedLanguage }}" data-piatto-id="{{ $piatto->id }}" style="width: 100%;">
                                <div class="d-flex justify-content-start align-items-center gap-2">
                                    <div class="d-flex flex-column py-2 flex-fill">
                                        <div class="d-flex justify-content-between align-items-center piatto-info">
                                            <div class="d-flex flex-column align-items-start justify-content-center">
                                                <div class="d-flex">
                                                    <p class="piatto-nome align-self-center fs-md-5 fs-6  ">{!! $piatto->nome($selectedLanguage) !!}

                                                    </p>
                                                    @if ($piatto->surgelato)
                                                        <i class="bi bi-snow2 align-self-start icona-congelato"></i>
                                                    @endif
                                                </div>
                                                @if ($piatto->show_desc)
                                                    <p class="piatto-descrizione fs-6  pe-2" >{!! $piatto->descrizione($selectedLanguage) !!}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center px-2">
                                        @if (fmod($piatto->prezzo, 1) == 0)
                                            <p class="piatto-prezzo ps-2  fs-md-5 fs-6">{{ number_format($piatto->prezzo, 0, ',', '.') }}€</p>
                                        @else
                                            <p class="piatto-prezzo ps-2  fs-md-5 fs-6">{{ number_format($piatto->prezzo, 2, ',', '.') }}€</p>
                                        @endif
                                    </div>
                                    @if ($piatto->photo)
                                        <div>
                                            <div style="border-radius: 13px; height: 10vh; width: 10vh; background-image: url('{{ Storage::url($piatto->photo) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach


                        <div class="accordion my-3" id="sottocategorieAccordion{{ $categoria->id }}">
                            @foreach ($categoria->sottocategorie as $sottocategoria)
                                @if($sottocategoria->piattiSottocategorie->count() > 0)
                                    <div class="accordion-item" x-data="{ open: false }">
                                        <h2 class="accordion-header d-flex accordion-custom-menu" id="headingSotto{{ $sottocategoria->id }}">
                                            <button class="accordion-button collapsed " :class="{ 'collapsed': !open }" type="button" @click="open = !open" data-bs-toggle="collapse" data-bs-target="#collapseSotto{{ $sottocategoria->id }}" aria-expanded="false" aria-controls="collapseSotto{{ $sottocategoria->id }}">
                                                {!! $sottocategoria->nome($selectedLanguage) !!}
                                            </button>
                                        </h2>
                                        <div style="border-radius: 12px; background-size: cover; background-blend-mode: multiply;" id="collapseSotto{{ $sottocategoria->id }}" class="accordion-collapse collapse" :class="{ 'show': open }" aria-labelledby="headingSotto{{ $sottocategoria->id }}" data-bs-parent="#sottocategorieAccordion{{ $categoria->id }}">
                                            <div class="accordion-body" style="padding-left: 5px !important; padding-right: 0.1rem !important;">
                                                @foreach ($sottocategoria->piattiSottocategorie as $piatto)
                                                    <div class=" py-2 tabella-piatto-sottocategoria" style="border-bottom: 1px solid var(--bg-border-bottom-piatto);" data-lingua="{{ $selectedLanguage }}" data-piatto-id="{{ $piatto->id }}" data-asporto="{{ false }}" style="width: 100%;">
                                                        <div class="d-flex justify-content-start align-items-center gap-2">
                                                            <div class="d-flex flex-column py-2 flex-fill">
                                                                <div class="d-flex justify-content-between align-items-center piatto-info">
                                                                    <div class="d-flex flex-column align-items-start justify-content-center">
                                                                        <div class="d-flex">
                                                                            <p class="piatto-nome align-self-center fs-md-5 fs-6  ">{!! $piatto->nome($selectedLanguage) !!}</p>
                                                                            @if ($piatto->surgelato)
                                                                                <i class="bi bi-snow2 align-self-start icona-congelato"></i>
                                                                            @endif
                                                                        </div>
                                                                        @if ($piatto->show_desc)
                                                                            <p class="piatto-descrizione fs-6 pe-2">{!! $piatto->descrizione($selectedLanguage) !!}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-center align-items-center px-2">
                                                                @if (fmod($piatto->prezzo, 1) == 0)
                                                                    <p class="piatto-prezzo ps-2 fs-md-5 fs-6">{{ number_format($piatto->prezzo, 0, ',', '.') }}€</p>
                                                                @else
                                                                    <p class="piatto-prezzo ps-2 fs-md-5 fs-6">{{ number_format($piatto->prezzo, 2, ',', '.') }}€</p>
                                                                @endif
                                                            </div>
                                                            @if ($piatto->photo)
                                                                <div>
                                                                    <div style="border-radius: 13px; height: 10vh; width: 10vh; background-image: url('{{ Storage::url($piatto->photo) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="accordion my-3" id="sottoSottocategorieAccordion{{ $categoria->id }}">
                                                    @foreach ($sottocategoria->sottoSottocategorie as $sottoSottocategoria)
                                                        @if($sottoSottocategoria->piattiSottoSottocategorie->count() > 0)
                                                            <div class="accordion-item" x-data="{ open: false }">
                                                                <h2 class="accordion-header d-flex accordion-custom-menu" id="headingSottoSotto{{ $sottoSottocategoria->id }}">
                                                                    <button class="accordion-button collapsed " :class="{ 'collapsed': !open }" type="button" @click="open = !open" data-bs-toggle="collapse" data-bs-target="#collapseSottoSotto{{ $sottoSottocategoria->id }}" aria-expanded="false" aria-controls="collapseSottoSotto{{ $sottoSottocategoria->id }}">
                                                                        {!! $sottoSottocategoria->nome($selectedLanguage) !!}
                                                                    </button>
                                                                </h2>
                                                                <div style="border-radius: 12px; background-size: cover; background-blend-mode: multiply;" id="collapseSottoSotto{{ $sottoSottocategoria->id }}" class="accordion-collapse collapse" :class="{ 'show': open }" aria-labelledby="headingSottoSotto{{ $sottoSottocategoria->id }}" data-bs-parent="#sottoSottocategorieAccordion{{ $categoria->id }}">
                                                                    <div class="accordion-body" style="padding-left: 5px !important; padding-right: 0.1rem !important;">
                                                                        @foreach ($sottoSottocategoria->piattiSottoSottocategorie as $piatto)
                                                                            <div class=" py-2 tabella-piatto-sotto-sottocategoria" style="border-bottom: 1px solid var(--bg-border-bottom-piatto);" data-lingua="{{ $selectedLanguage }}" data-piatto-id="{{ $piatto->id }}" data-asporto="{{ false }}" style="width: 100%;">
                                                                                <div class="d-flex justify-content-start align-items-center gap-2">
                                                                                    <div class="d-flex flex-column py-2 flex-fill">
                                                                                        <div class="d-flex justify-content-between align-items-center piatto-info">
                                                                                            <div class="d-flex flex-column align-items-start justify-content-center">
                                                                                                <div class="d-flex">
                                                                                                    <p class="piatto-nome align-self-center fs-md-5 fs-6  ">{!! $piatto->nome($selectedLanguage) !!}</p>
                                                                                                    @if ($piatto->surgelato)
                                                                                                        <i class="bi bi-snow2 align-self-start icona-congelato"></i>
                                                                                                    @endif
                                                                                                </div>
                                                                                                @if ($piatto->show_desc)
                                                                                                    <p class="piatto-descrizione fs-6 pe-2" >{!! $piatto->descrizione($selectedLanguage) !!}</p>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="d-flex justify-content-center align-items-center px-2">
                                                                                        @if (fmod($piatto->prezzo, 1) == 0)
                                                                                            <p class="piatto-prezzo ps-2 fs-md-5 fs-6">{{ number_format($piatto->prezzo, 0, ',', '.') }}€</p>
                                                                                        @else
                                                                                            <p class="piatto-prezzo ps-2 fs-md-5 fs-6">{{ number_format($piatto->prezzo, 2, ',', '.') }}€</p>
                                                                                        @endif
                                                                                    </div>
                                                                                    @if ($piatto->photo)
                                                                                        <div>
                                                                                            <div style="border-radius: 13px; height: 10vh; width: 10vh; background-image: url('{{ Storage::url($piatto->photo) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>


                        <div class="d-flex justify-content-between align-items-center mt-3">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($selectedLanguage == 'it')
        <button data-bs-toggle="modal" data-bs-target="#allergeniModal" class="btn btn-secondary" >Legenda</button>
    @else
        <button data-bs-toggle="modal" data-bs-target="#allergeniModal" class="btn btn-secondary" >Legends</button>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="allergeniModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border: none !important;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $selectedLanguage == 'it' ? 'Legenda' : 'Legend' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap">
                        @php
                            $allergeni = \App\Models\Allergeni::get();
                        @endphp
                        <div class="f-flex flex-column ">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-snow2" style="color: rgb(0, 0, 0) !important; font-size: 1.5rem;"></i>
                                @if ($selectedLanguage == 'it')
                                    <p class="piatto-nome fs-5 fw-semibold m-0">Prodotto Congelato</p>
                                @else
                                    <p class="piatto-nome fs-5 fw-semibold m-0">Frozen Product</p>
                                @endif

                            </div>
                            <hr>
                            @foreach ($allergeni as $allergene)
                                <div class="d-flex align-items-center gap-2">
                                    <div data-bs-toggle="modal" data-bs-target="#allergeniModal" class="invert-image m-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center; border: none; background-color: var(--bg-None);"></div>
                                    <p class="piatto-nome fs-5 fw-semibold m-0">{{ $allergene->nome($selectedLanguage) }}</p>
                                </div>
                                <p class="piatto-descrizione fs-6 fw-normal m-0">{{ $allergene->descrizione($selectedLanguage) }}</p>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $socials = App\Models\SocialNetwork::where('enable', 1)->get();
    @endphp
    @if (Auth::user())
        <div class="d-flex flex-column align-items-center justify-content-center mt-5 mx-5">
            <div style="position: relative; width:fit-content; height: fit-content;">
                <h1 class="text-center  mb-0 testo-titolo-social" wire:model.live=@if ($this->selectedLanguage == 'it') "titolo_social_ita" @else "titolo_social_eng" @endif>
                    {{ $this->selectedLanguage == 'it' ? $titolo_social_ita : $titolo_social_eng }}
                </h1>
                <button wire:click="toggleTitoloSocial" style="position: absolute; top: 0; right: -2rem; border:none; background-color: var(--bg-None);"><i class="bi bi-pencil-fill"></i></button>
            </div>
            @if ($this->modifyTitoloSocial)
                <div class="d-flex gap-2 justify-content-center mb-4">
                    <input type="text" wire:model.live=@if ($this->selectedLanguage == 'it') "titolo_social_ita" @else "titolo_social_eng" @endif id="">
                    <button wire:click="saveTitoli" style="font-size: 1.5rem; border:none; background-color: var(--bg-None);" class="text-success"><i class="bi bi-check-circle"></i></button>
                    <button wire:click="setTitoli" style="font-size: 1.5rem; border:none; background-color: var(--bg-None);" class="text-danger"><i class="bi bi-x-circle"></i></button>
                </div>
            @endif
        </div>
    @else
        @if ($socials->isNotEmpty())
            <div class="d-flex flex-column align-items-center justify-content-center mt-5">
                <div style="position: relative; width:fit-content; height: fit-content;">
                    <h1 class="text-center  mb-0 testo-titolo-social">
                        {{ $this->selectedLanguage == 'it' ? $titolo_social_ita : $titolo_social_eng }}
                    </h1>
                </div>
            </div>
        @endif
    @endif



    @if ($socials->isNotEmpty())
        <div class="mb-5 d-flex justify-content-center gap-3 mt-3">
            @foreach ($socials as $social)
                <a href="{{ $social->link_profilo }}" target="_blank" class="d-block" style=" @if ($social->inverti) filter: invert(100%); -webkit-filter: invert(100%); @endif background-image: url('{{ Storage::url($social->photo) }}'); background-size: contain; background-position: center; background-repeat: no-repeat; height: 2rem; width: 2rem;"></a>
            @endforeach
        </div>
    @endif


    @php
        $sponsors = App\Models\Sponsor::where('enable', 1)->get();
    @endphp

    @if ($sponsors->count() > 4)
        <style>
            .swiper-sponsor>.swiper-wrapper {
                transition-timing-function: linear;
            }

            .swiper-slide-trasparent {
                background-color: #e9e9e900;
            }
        </style>
        <div class="swiper-sponsor">
            <div class="swiper-wrapper">
                @foreach ($sponsors as $sponsor)
                    <div class="swiper-slide swiper-slide-trasparent " style="width: fit-content;">
                        @if ($sponsor->link_sponsor)
                            <a href="{{ $sponsor->link_sponsor }}" target="_blank" class="d-block" style=" @if ($sponsor->inverti) filter: invert(100%); -webkit-filter: invert(100%); @endif background-image: url('{{ Storage::url($sponsor->photo) }}'); background-size: contain; background-position: center; background-repeat: no-repeat; height: 25vw; width: 25vw;">
                            </a>
                        @else
                            <div class="d-block" style=" @if ($sponsor->inverti) filter: invert(100%); -webkit-filter: invert(100%); @endif background-image: url('{{ Storage::url($sponsor->photo) }}'); background-size: contain; background-position: center; background-repeat: no-repeat; height: 25vw; width: 30vw;">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="mb-5 d-flex justify-content-center gap-3 mt-3">
            @foreach ($sponsors as $sponsor)
                @if ($sponsor->link_sponsor)
                    <a href="{{ $sponsor->link_sponsor }}" target="_blank" class="d-block" style=" @if ($sponsor->inverti) filter: invert(100%); -webkit-filter: invert(100%); @endif background-image: url('{{ Storage::url($sponsor->photo) }}'); background-size: contain; background-position: center; background-repeat: no-repeat; height: 20vw; width: 20vw;"></a>
                @else
                    <div class="d-block" style=" @if ($sponsor->inverti) filter: invert(100%); -webkit-filter: invert(100%); @endif background-image: url('{{ Storage::url($sponsor->photo) }}'); background-size: contain; background-position: center; background-repeat: no-repeat; height: 20vw; width: 20vw;"></div>
                @endif
            @endforeach
        </div>
    @endif



    @livewire('info-box-piatti')

</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiperSponsor = new Swiper('.swiper-sponsor', {
                loop: true,
                autoplay: {
                    delay: 1,
                    disableOnInteraction: false
                },
                slidesPerView: 'auto',
                speed: 5000,
                grabCursor: true,
                mousewheelControl: true,
                keyboardControl: true,
                // navigation: {
                //     nextEl: ".swiper-button-next",
                //     prevEl: ".swiper-button-prev"
                // }
            });


        });
    </script>
@endpush
