<div class="text-no-select">
    <h1 class=" fw-semibold @if (!Auth::user()) text-center fs-4 @else fs-5 @endif">Menù {{ env('APP_RISTORANTE') }}</h1>
    <div class="mb-3">
        <div class="d-flex justify-content-between">
            <div class="dropdown">

                <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cambia Lingua Del Menù
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a wire:click="$dispatch('switchLanguage', ['it'])" class="dropdown-item" href="#">
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-image: url('/svg/bandiera_italiana.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center;"></div>
                                Italiano
                            </div>
                        </a>
                    </li>
                    <li>
                        <a wire:click="$dispatch('switchLanguage', ['en'])" class="dropdown-item" href="#">
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-image: url('/svg/bandiera_inglese.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center;"></div>
                                English
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <style>
        .accordion-custom-menu .accordion-button::after {
            display: none !important;
        }

        .ul-menu {
            list-style: none !important;
            padding: 0;
        }

        .li-menu {
            border: var(--bg-lightgreen) 2px solid;
            border-radius: 13px;
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
    </style>

    <div class="accordion" id="menuAccordion">
        <div class="contenitore1">
            @foreach ($categorie as $categoria)
                <div class="accordion-item element-categoria" data-categoria-id ="{{ $categoria->id }}" x-data="{ open: false }">
                    <h2 class="accordion-header d-flex accordion-custom-menu" id="heading{{ $categoria->id }}">
                        <button class="accordion-button text-no-select" :class="{ 'collapsed': !open }" type="button" @click="open = !open" data-bs-toggle="collapse" data-bs-target="#collapse{{ $categoria->id }}" aria-expanded="true" aria-controls="collapse{{ $categoria->id }}">
                            {!! $categoria->nome($selectedLanguage) !!}
                        </button>
                        @if (Auth::user())
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <div class=" mb-1">
                                    <button wire:click="enableCategoria({{ $categoria->id }})" class=" btn @if ($categoria->enable) btn-success @else btn-warning @endif" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                        @if ($categoria->enable)
                                            <i class="bi bi-patch-check"></i>
                                        @else
                                            <i class="bi bi-patch-exclamation"></i>
                                        @endif
                                    </button>
                                </div>
                                <div class="dropdown mb-1">
                                    <button class="btn btn-primary" style="padding: 0 5px; margin-right: 0.5rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a wire:click="$dispatch('open-modal', { data: { type: 'piatto', categoria_id: {{ $categoria->id }} }})" class="dropdown-item" href="#">Aggiungi un Piatto</a></li>
                                        <li><a wire:click="$dispatch('open-modal', { data: { type: 'sottocategoria', categoria_id: {{ $categoria->id }}} })" class="dropdown-item" href="#">Aggiungi Sottocategoria</a></li>
                                        <li><a wire:click="$dispatch('open-modal', { data: { type: 'rinomina_categoria', categoria_id: {{ $categoria->id }}} })" class="dropdown-item" href="#">Rinomina Categoria</a></li>
                                        <li><a wire:click="$dispatch('open-modal', { data: { type: 'elimina_categoria', categoria_id: {{ $categoria->id }}} })" class="dropdown-item" href="#">Elimina Categoria</a></li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </h2>
                    <div id="collapse{{ $categoria->id }}" class="accordion-collapse collapse" :class="{ 'show': open }" aria-labelledby="heading{{ $categoria->id }}" data-bs-parent="#menuAccordion">
                        <div class="accordion-body">
                            <ul class="ul-menu">
                                <div class="contenitore2">
                                    @foreach ($categoria->piatti as $piatto)
                                        <li class="my-2 px-2 py-1 li-menu element-piatto " data-piatto-id ="{{ $piatto->id }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-fill">
                                                    <div class="d-flex flex-column w-100">
                                                        @php
                                                            $allergeni = json_decode($piatto->allergeni) ?? null;
                                                        @endphp
                                                        @if ($allergeni)
                                                            <div class="d-flex flex-wrap" style="width: 80%">
                                                                @foreach ($allergeni as $allergene)
                                                                    @php
                                                                        $allergene = \App\Models\Allergeni::findOrFail($allergene);
                                                                    @endphp
                                                                    {{-- <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $allergene->nome($selectedLanguage) }}" class="invert-image m-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center;"></div> --}}
                                                                    <button data-bs-toggle="modal" data-bs-target="#allergeniModal" class="invert-image m-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center; border: none; background-color: var(--bg-None);"></button>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        <hr class="dotted-circle-hr">
                                                        <p class="fs-5 fw-bold m-0 text-no-select"><span class="piatto-nome">{!! $piatto->nome($selectedLanguage) !!}</span>
                                                            @if ($piatto->surgelato)
                                                                <i class="bi bi-snow2 ms-2"></i>
                                                            @endif
                                                            </span>
                                                        </p>

                                                        <p class="fs-6 fw-normal m-0"><span class="piatto-nome fw-semibold ">Prezzo:</span> <span class="piatto-prezzo">{{ number_format($piatto->prezzo, 2, ',', '.') }}€</p>


                                                    </div>
                                                </div>
                                                @if (Auth::user())
                                                    <div class="d-flex gap-2">
                                                        <button wire:click="$dispatch('open-modal', { data: { type: 'modifica_piatto_categoria', piatto_id: {{ $piatto->id }} }})" class="btn btn-primary" style="color: var(--color-text) !important; padding: 0 5px;" type="button"><i class="bi bi-pencil-fill"></i></button>
                                                        <button wire:click="enablePiatto({{ $piatto->id }})" class="btn @if ($piatto->enable) btn-success @else btn-warning @endif" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                                            @if ($piatto->enable)
                                                                <i class="bi bi-patch-check"></i>
                                                            @else
                                                                <i class="bi bi-patch-exclamation"></i>
                                                            @endif
                                                        </button>
                                                        <button wire:click="$dispatch('open-modal', { data: { type: 'elimina_piatto_categoria', piatto_id: {{ $piatto->id }} }})" class="btn btn-danger" style="color: var(--color-text) !important; padding: 0 5px;" type="button"><i class="bi bi-x-lg"></i></button>
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($piatto->descrizione($selectedLanguage))
                                                <hr class="dotted-circle-hr">
                                                <p class="fs-6 fw-normal m-0 piatto-descrizione">{!! $piatto->descrizione($selectedLanguage) !!}</p>
                                            @endif
                                        </li>
                                    @endforeach
                                </div>
                            </ul>

                            <div class="accordion" id="sottocategorieAccordion{{ $categoria->id }}">
                                <div class="contenitore3">
                                    @foreach ($categoria->sottocategorie as $sottocategoria)
                                        <div class="accordion-item element-sottocategoria" data-sottocategoria-id ="{{ $sottocategoria->id }}" x-data="{ open: false }">
                                            <h2 class="accordion-header d-flex" id="headingSotto{{ $sottocategoria->id }}">
                                                <button class="accordion-button collapsed" :class="{ 'collapsed': !open }" type="button" @click="open = !open" data-bs-toggle="collapse" data-bs-target="#collapseSotto{{ $sottocategoria->id }}" aria-expanded="false" aria-controls="collapseSotto{{ $sottocategoria->id }}">
                                                    {!! $sottocategoria->nome($selectedLanguage) !!}
                                                </button>
                                                @if (Auth::user())
                                                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                                        {{-- @if ($loop->first)
                                                        @else
                                                            <!-- Bottone Sposta in Alto -->
                                                            <button wire:click="moveSottocategoria({{ $sottocategoria->id }}, 'up')" class="btn btn-primary" style="padding: 0 5px;" type="button">
                                                                <i class="bi bi-arrow-up"></i>
                                                            </button>
                                                        @endif

                                                        @if ($loop->last)
                                                        @else
                                                            <!-- Bottone Sposta in Basso -->
                                                            <button wire:click="moveSottocategoria({{ $sottocategoria->id }}, 'down')" class="btn btn-primary" style="padding: 0 5px;" type="button">
                                                                <i class="bi bi-arrow-down"></i>
                                                            </button>
                                                        @endif --}}

                                                        <div class="mb-1">
                                                            <button wire:click="enableSottocategoria({{ $sottocategoria->id }})" class="btn @if ($sottocategoria->enable) btn-success @else btn-warning @endif" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                                                @if ($sottocategoria->enable)
                                                                    <i class="bi bi-patch-check"></i>
                                                                @else
                                                                    <i class="bi bi-patch-exclamation"></i>
                                                                @endif
                                                            </button>
                                                        </div>
                                                        <div class="dropdown mb-1">
                                                            <button class="btn btn-primary" style="padding: 0 5px; margin-right: 0.5rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a wire:click="$dispatch('open-modal', { data: { type: 'piatto', sottocategoria_id: {{ $sottocategoria->id }} }})" class="dropdown-item" href="#">Aggiungi un Piatto</a></li>
                                                                <li><a wire:click="$dispatch('open-modal', { data: { type: 'sottoSottocategoria', sottocategoria_id: {{ $sottocategoria->id }}} })" class="dropdown-item" href="#">Aggiungi Sotto-Sottocategoria</a></li>
                                                                <li><a wire:click="$dispatch('open-modal', { data: { type: 'rinomina_sottocategoria', sottocategoria_id: {{ $sottocategoria->id }}} })" class="dropdown-item" href="#">Rinomina Sottoategoria</a></li>
                                                                <li><a wire:click="$dispatch('open-modal', { data: { type: 'elimina_sottocategoria', sottocategoria_id: {{ $sottocategoria->id }}} })" class="dropdown-item" href="#">Elimina Sottoategoria</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            </h2>
                                            <div id="collapseSotto{{ $sottocategoria->id }}" class="accordion-collapse collapse" :class="{ 'show': open }" aria-labelledby="headingSotto{{ $sottocategoria->id }}" data-bs-parent="#sottocategorieAccordion{{ $categoria->id }}">
                                                <div class="accordion-body">
                                                    <ul class="ul-menu">
                                                        <div class="contenitore4">
                                                            @foreach ($sottocategoria->piattiSottocategorie as $piatto)
                                                                <li class="my-2 px-2 py-1 li-menu element-piatto-sottocategoria" data-piatto-sottocategoria-id ="{{ $piatto->id }}">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="flex-fill">
                                                                            <div class="d-flex flex-column w-100">
                                                                                @php
                                                                                    $allergeni = json_decode($piatto->allergeni) ?? null;
                                                                                @endphp
                                                                                @if ($allergeni)
                                                                                    <div class="d-flex flex-wrap" style="width: 50%">
                                                                                        @foreach ($allergeni as $allergene)
                                                                                            @php
                                                                                                $allergene = \App\Models\Allergeni::findOrFail($allergene);
                                                                                            @endphp
                                                                                            {{-- <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $allergene->nome($selectedLanguage) }}" class="invert-image m-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center;"></div> --}}
                                                                                            <button data-bs-toggle="modal" data-bs-target="#allergeniModal" class="invert-image m-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center; border: none; background-color: var(--bg-None);"></button>
                                                                                        @endforeach
                                                                                    </div>
                                                                                @endif
                                                                                <hr class="dotted-circle-hr">
                                                                                <p class="fs-5 fw-bold m-0"><span class="piatto-nome">{!! $piatto->nome($selectedLanguage) !!}</span>
                                                                                    @if ($piatto->surgelato)
                                                                                        <i class="bi bi-snow2 ms-2"></i>
                                                                                    @endif
                                                                                    </span>
                                                                                </p>

                                                                                <p class="fs-6 fw-normal m-0"><span class="piatto-nome fw-semibold">Prezzo:</span> <span class="piatto-prezzo">{{ number_format($piatto->prezzo, 2, ',', '.') }}€</p>

                                                                            </div>
                                                                        </div>
                                                                        @if (Auth::user())
                                                                            <div class="d-flex gap-2">
                                                                                <button wire:click="$dispatch('open-modal', { data: { type: 'modifica_piatto_sottocategoria', piatto_id: {{ $piatto->id }} }})" class="btn btn-primary" style="color: var(--color-text) !important; padding: 0 5px;" type="button"><i class="bi bi-pencil-fill"></i></button>
                                                                                <button wire:click="enablePiattoSottocategoria({{ $piatto->id }})" class="btn @if ($piatto->enable) btn-success @else btn-warning @endif" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                                                                    @if ($piatto->enable)
                                                                                        <i class="bi bi-patch-check"></i>
                                                                                    @else
                                                                                        <i class="bi bi-patch-exclamation"></i>
                                                                                    @endif
                                                                                </button>
                                                                                <button wire:click="$dispatch('open-modal', { data: { type: 'elimina_piatto_sottocategoria', piatto_id: {{ $piatto->id }} }})" class="btn btn-danger" style="color: var(--color-text) !important; padding: 0 5px;" type="button"><i class="bi bi-x-lg"></i></button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    @if ($piatto->descrizione($selectedLanguage))
                                                                        <hr class="dotted-circle-hr">
                                                                        <p class="fs-6 fw-normal m-0 piatto-descrizione">{!! $piatto->descrizione($selectedLanguage) !!}</p>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </div>
                                                    </ul>

                                                    <div class="accordion" id="sottoSottocategorieAccordion{{ $sottocategoria->id }}">
                                                        <div class="contenitore5">
                                                            @foreach ($sottocategoria->sottoSottocategorie as $sottoSottocategoria)
                                                                <div class="accordion-item element-sotto-sottocategoria" data-sotto-sottocategoria-id="{{ $sottoSottocategoria->id }}" x-data="{ open: false }">
                                                                    <h2 class="accordion-header d-flex" id="headingSottoSotto{{ $sottoSottocategoria->id }}">
                                                                        <button class="accordion-button collapsed" :class="{ 'collapsed': !open }" type="button" @click="open = !open" data-bs-toggle="collapse" data-bs-target="#collapseSottoSotto{{ $sottoSottocategoria->id }}" aria-expanded="false" aria-controls="collapseSottoSotto{{ $sottoSottocategoria->id }}">
                                                                            {!! $sottoSottocategoria->nome($selectedLanguage) !!}
                                                                        </button>
                                                                        @if (Auth::user())
                                                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                                                <div class="mb-1">
                                                                                    <button wire:click="enableSottoSottocategoria({{ $sottoSottocategoria->id }})" class="btn @if ($sottoSottocategoria->enable) btn-success @else btn-warning @endif" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                                                                        @if ($sottoSottocategoria->enable)
                                                                                            <i class="bi bi-patch-check"></i>
                                                                                        @else
                                                                                            <i class="bi bi-patch-exclamation"></i>
                                                                                        @endif
                                                                                    </button>
                                                                                </div>
                                                                                <div class="dropdown mb-1">
                                                                                    <button class="btn btn-primary" style="padding: 0 5px; margin-right: 0.5rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                        <i class="bi bi-three-dots"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu">
                                                                                        <li><a wire:click="$dispatch('open-modal', { data: { type: 'piatto', sotto_sottocategoria_id: {{ $sottoSottocategoria->id }} }})" class="dropdown-item" href="#">Aggiungi un Piatto</a></li>
                                                                                        <li><a wire:click="$dispatch('open-modal', { data: { type: 'rinomina_sotto_sottocategoria', sotto_sottocategoria_id: {{ $sottoSottocategoria->id }}} })" class="dropdown-item" href="#">Rinomina Sotto-Sottoategoria</a></li>
                                                                                        <li><a wire:click="$dispatch('open-modal', { data: { type: 'elimina_sotto_sottocategoria', sotto_sottocategoria_id: {{ $sottoSottocategoria->id }}} })" class="dropdown-item" href="#">Elimina Sotto-Sottoategoria</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </h2>
                                                                    <div id="collapseSottoSotto{{ $sottoSottocategoria->id }}" class="accordion-collapse collapse" :class="{ 'show': open }" aria-labelledby="headingSottoSotto{{ $sottoSottocategoria->id }}" data-bs-parent="#sottoSottocategorieAccordion{{ $sottocategoria->id }}">
                                                                        <div class="accordion-body">
                                                                            <ul class="ul-menu">
                                                                                <div class="contenitore6">
                                                                                    @foreach ($sottoSottocategoria->piattiSottoSottocategorie as $piatto)
                                                                                        <li class="my-2 px-2 py-1 li-menu element-piatto-sotto-sottocategoria" data-piatto-sotto-sottocategoria-id="{{ $piatto->id }}">
                                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                                <div class="flex-fill">
                                                                                                    <div class="d-flex flex-column w-100">
                                                                                                        @php
                                                                                                            $allergeni = json_decode($piatto->allergeni) ?? null;
                                                                                                        @endphp
                                                                                                        @if ($allergeni)
                                                                                                            <div class="d-flex flex-wrap" style="width: 50%">
                                                                                                                @foreach ($allergeni as $allergene)
                                                                                                                    @php
                                                                                                                        $allergene = \App\Models\Allergeni::findOrFail($allergene);
                                                                                                                    @endphp
                                                                                                                    <button data-bs-toggle="modal" data-bs-target="#allergeniModal" class="invert-image m-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center; border: none; background-color: var(--bg-None);"></button>
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        <hr class="dotted-circle-hr">
                                                                                                        <p class="fs-5 fw-bold m-0"><span class="piatto-nome">{!! $piatto->nome($selectedLanguage) !!}</span>
                                                                                                            @if ($piatto->surgelato)
                                                                                                                <i class="bi bi-snow2 ms-2"></i>
                                                                                                            @endif
                                                                                                        </p>

                                                                                                        <p class="fs-6 fw-normal m-0"><span class="piatto-nome fw-semibold">Prezzo:</span> <span class="piatto-prezzo">{{ number_format($piatto->prezzo, 2, ',', '.') }}€</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                @if (Auth::user())
                                                                                                    <div class="d-flex gap-2">
                                                                                                        <button wire:click="$dispatch('open-modal', { data: { type: 'modifica_piatto_sotto_sottocategoria', piatto_id: {{ $piatto->id }} }})" class="btn btn-primary" style="color: var(--color-text) !important; padding: 0 5px;" type="button"><i class="bi bi-pencil-fill"></i></button>
                                                                                                        <button wire:click="enablePiattoSottoSottocategoria({{ $piatto->id }})" class="btn @if ($piatto->enable) btn-success @else btn-warning @endif" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                                                                                            @if ($piatto->enable)
                                                                                                                <i class="bi bi-patch-check"></i>
                                                                                                            @else
                                                                                                                <i class="bi bi-patch-exclamation"></i>
                                                                                                            @endif
                                                                                                        </button>
                                                                                                        <button wire:click="$dispatch('open-modal', { data: { type: 'elimina_piatto_sotto_sottocategoria', piatto_id: {{ $piatto->id }} }})" class="btn btn-danger" style="color: var(--color-text) !important; padding: 0 5px;" type="button"><i class="bi bi-x-lg"></i></button>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                            @if ($piatto->descrizione($selectedLanguage))
                                                                                                <hr class="dotted-circle-hr">
                                                                                                <p class="fs-6 fw-normal m-0 piatto-descrizione">{!! $piatto->descrizione($selectedLanguage) !!}</p>
                                                                                            @endif
                                                                                        </li>
                                                                                    @endforeach
                                                                                </div>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if (Auth::user())
        <button wire:click="$dispatch('open-modal', { data: { type: 'categoria' }})" class="btn btn-primary mt-3">Aggiungi Una Categoria</button>
    @endif

    <!-- Modal Component -->
    @livewire('add-element-modal')

    <!-- Modal -->
    <div class="modal fade" id="allergeniModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:var(--bg-White);">
                <div class="modal-header" style="border: none !important;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $selectedLanguage == 'it' ? 'Tabella Allergeni' : 'Allergen Table' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap">
                        @php
                            $allergeni = \App\Models\Allergeni::get();
                        @endphp
                        <div class="f-flex flex-column ">
                            @foreach ($allergeni as $allergene)
                                <hr>
                                <div class="d-flex align-items-center gap-2">
                                    <div data-bs-toggle="modal" data-bs-target="#allergeniModal" class="invert-image m-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center; border: none; background-color: var(--bg-None);"></div>
                                    <p class="fs-5 fw-semibold m-0">{{ $allergene->nome($selectedLanguage) }}</p>
                                </div>
                                <p class="fs-6 fw-normal m-0">{{ $allergene->descrizione($selectedLanguage) }}</p>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            function initializeSortable() {
                const lists = document.querySelectorAll('.contenitore1, .contenitore2, .contenitore3, .contenitore4, .contenitore5, .contenitore6');
                let num = 0;
                lists.forEach(list => {
                    num += 1;
                    new Sortable(list, {

                        group: 'elements' + num,
                        animation: 150,
                        pull: false,
                        put: false,
                        sort: true,
                        delay: 100,
                        delayOnTouchOnly: true,
                        onEnd: function(evt) {
                            const categoriaId = evt.from.closest('.element-categoria')?.dataset.categoriaId;

                            // Recupera gli ID dei piatti e sottocategorie dopo un cambiamento di posizione
                            const categorieId = Array.from(evt.from.querySelectorAll('.element-categoria')).map(item => item.dataset.categoriaId);
                            const piattiIds = Array.from(evt.from.querySelectorAll('.element-piatto')).map(item => item.dataset.piattoId);

                            const sottocategorieIds = Array.from(evt.from.querySelectorAll('.element-sottocategoria')).map(item => item.dataset.sottocategoriaId);
                            const piattiSottocategorieIds = Array.from(evt.from.querySelectorAll('.element-piatto-sottocategoria')).map(item => item.dataset.piattoSottocategoriaId);


                            const sottoSottocategorieIds = Array.from(evt.from.querySelectorAll('.element-sotto-sottocategoria')).map(item => item.dataset.sottoSottocategoriaId);
                            const piattiSottoSottocategorieIds = Array.from(evt.from.querySelectorAll('.element-piatto-sotto-sottocategoria')).map(item => item.dataset.piattoSottoSottocategoriaId);

                            Livewire.dispatch('updateElementOrder', {
                                data: {
                                    categoriaId,
                                    categorieId,
                                    piattiIds,
                                    sottocategorieIds,
                                    piattiSottocategorieIds,
                                    sottoSottocategorieIds,
                                    piattiSottoSottocategorieIds,
                                    target: evt.to.closest('.element-categoria')?.dataset.categoriaId,
                                    targetSubcategory: evt.to.closest('.element-sottocategoria')?.dataset.sottocategoriaId,
                                    targetSubSubcategory: evt.to.closest('.element-sotto-sottocategoria')?.dataset.sottoSottocategoriaId,
                                }
                            });
                        }
                    });
                });
            }

            initializeSortable(); // Inizializza Sortable all'avvio

            Livewire.on('elementChanged', () => {
                setTimeout(() => {
                    initializeSortable();
                }, 500);
            });
        });
    </script>
@endpush


{{--
---------------------------------------------------
    STRUTTURA HTML PER IL DRAG AND DROP
---------------------------------------------------

<div class="contenitore1">
    @foreach ($categorie as $categoria)
        <div class="element-categoria" data-categoria-id ="{{ $categoria->id }}">
            <div class="contenitore2">
                @foreach ($categorie->piatti as $piatto)
                    <div class="element-piatto" data-piatto-id ="{{ $categoria->id }}">

                    </div>
                @endforeach
            </div>
            <div class="contenitore3">
                @foreach ($sottocategorie as $sottocategoria)
                    <div class="element-sottocategoria" data-sottocategoria-id ="{{ $sottocategoria->id }}">
                        <div class="contenitore4">
                            @foreach ($sottocategorie->piatti as $piatto)
                                <div class="element-piatto-sottocategoria" data-piatto-sottocategoria-id ="{{ $piatto->id }}">

                                </div>
                            @endforeach
                        </div>

                        <div class="contenitore5">
                            @foreach ($sottocategorie as $sottocategoria)
                                <div class="element-sottocategoria" data-sottocategoria-id ="{{ $sottocategoria->id }}">
                                    <div class="contenitore5">
                                        @foreach ($sottocategorie->piatti as $piatto)
                                            <div class="element-piatto-sottocategoria" data-piatto-sottocategoria-id ="{{ $piatto->id }}">

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>
--}}
