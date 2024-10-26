<div class="">
    <style>
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
    <h1 class="fs-5 fw-semibold">Gestisci i tuoi Special di seguito!</h1>
    <div class="d-flex justify-content-between align-items-center">
        <button class="btn btn-primary my-2" style="padding: 0 5px; margin-right: 0.5rem;" wire:click="$dispatch('openModal')">Aggiungi Piatto del Giorno</button>
        <div>
            <div class="dropdown">
                <button class="btn btn-primary" style="padding: 0 5px; margin-right: 0.5rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
    <div class="p-3" style="background-color: var(--bg-White); border-radius: 18px;">
        <ul class="mt-4 ul-menu">
            @php
                $numeroPiatti = count($piattiDelGiorno);
            @endphp
            @if ($numeroPiatti == 0)
                <div class="d-flex justify-content-center">
                    <p class="fs-5 fw-semibold btn btn-secondary" style="cursor: default;">Aggiungi il tuo primo piatto per cominciare!</p>
                </div>
            @else
                @foreach ($piattiDelGiorno as $piatto)
                    <li class="li-menu px-2 py-1 my-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-fill">
                                    <div class="d-flex flex-column w-100">
                                        <p class="fs-6 fw-bold m-0">{!! $piatto->nome($selectedLanguage) !!} @if ($piatto->surgelato) <i class="bi bi-snow2 ms-2"></i> @endif </p>
                                        <p class="fs-6 fw-normal m-0"><span class="fw-semibold">Prezzo:</span> {{ number_format($piatto->prezzo, 2, ',', '.') }}€</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 align-items-center">
                                <button wire:click="$dispatch('openEditModal', [{{ $piatto->id }}])" class="btn btn-primary" style="color: var(--color-text) !important; padding: 0 5px;" type="button"><i class="bi bi-pencil-fill"></i></button>
                                <button wire:click="enablePiatto({{ $piatto->id }})" class="btn @if ($piatto->enable) btn-success @else btn-warning @endif" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                    @if ($piatto->enable)
                                        <i class="bi bi-patch-check"></i>
                                    @else
                                        <i class="bi bi-patch-exclamation"></i>
                                    @endif
                                </button>
                                <button wire:click="$dispatch('deletePiatto' ,[{{ $piatto->id }}])" class="btn btn-danger" style="color: var(--color-text) !important; padding: 0 5px;" type="button"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </div>
                        @if ($piatto->descrizione($selectedLanguage))
                            <hr class="dotted-circle-hr">
                            <p class="fs-6 fw-normal m-0">{!! $piatto->descrizione($selectedLanguage) !!}</p>
                        @endif

                        @php
                            $allergeni = json_decode($piatto->allergeni) ?? null;
                        @endphp
                        @if ($allergeni)
                            <hr class="dotted-circle-hr">
                            <p class="fs-6 fw-normal m-0">Allergeni</p>
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
                    </li>
                @endforeach
            @endif

        </ul>

        @livewire('add-fuori-menu-modal')
    </div>

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
