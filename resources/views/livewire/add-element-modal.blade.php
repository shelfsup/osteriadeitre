<div class="modal fade @if ($showModal) show @endif" id="addElementModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--bg-White) !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @if (str_contains($type, 'elimina'))
                        Conferma Eliminazione
                    @elseif (str_contains($type, 'modifica'))
                        Modifica {{ ucfirst(explode('_', $type)[1]) }}
                    @elseif (str_contains($type, 'rinomina'))
                        Rinomina {{ ucfirst(explode('_', $type)[1]) }}
                    @else
                        Aggiungi {{ ucfirst($type) }}
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (str_contains($type, 'elimina'))
                    <p>Sei sicuro di voler eliminare questo elemento?</p>
                @else
                    <form>
                        @if ($type == 'piatto' || str_contains($type, 'modifica_piatto'))
                            <div class="mt-3">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <input class="d-none @error('photo_url') is-invalid @enderror" id="photo_url" name="photo_url" type="file" wire:model="photo_url" />
                                    <div style="position: relative; background-color: var(--bg-lightgreen2); border-radius: 13px;">
                                        @if ($photoPreview)
                                            <div class="d-flex justify-content-center align-items-center immagine-profilo border-Gray-5 bg-Trasparent " style="border-radius: 13px; height: 15vh !important; width: 15vh !important; background-image: url({{ $photoPreview }});background-position: center;background-repeat: no-repeat; background-size: cover;">

                                            </div>
                                        @else
                                            <div class="d-flex justify-content-center align-items-center immagine-profilo border-Gray-5 bg-Trasparent " style="border-radius: 13px; height: 15vh !important; width: 15vh !important;">
                                                <span class="rounded-circle" style="font-size: 100px; font-weight: 600; color: var(--color-likeBorder) !important;">
                                                    <i class="bi bi-image"></i>
                                                </span>
                                            </div>
                                        @endif




                                    </div>
                                    @error('photo_url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <!-- Edit Photo Button -->
                                    <button id="previewImmagine" type="button" class="btn btn-primary mt-2 mb-3" onclick="Livewire.dispatch('uploadPhotoPreview')" wire:click="clearPhotoPreview">
                                        <!-- Aggiungi l'evento wire:click per cancellare l'anteprima -->
                                        <i class="bi bi-pencil-fill" style="padding:0 !important;"></i> Carica una immagine
                                    </button>
                                </div>
                            </div>
                        @endif



                        <div class="form-group mt-2">
                            <label for="nome_italiano">Nome Italiano</label>
                            {{-- <input type="text" class="form-control" id="nome_italiano" wire:model="nome_italiano"> --}}
                            <textarea type="text" class="form-control" id="nome_italiano" wire:model="nome_italiano"></textarea>
                            @error('nome_italiano')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($type == 'piatto' || str_contains($type, 'modifica_piatto'))
                            <div class="form-group mt-2">
                                <label for="descrizione_italiano">Descrizione Italiano</label>
                                <textarea type="text" class="form-control" id="descrizione_italiano" wire:model="descrizione_italiano"></textarea>
                                @error('descrizione_italiano')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group mt-2">
                            <label for="nome_inglese">Nome Inglese</label>
                            {{-- <input type="text" class="form-control" id="nome_inglese" wire:model="nome_inglese"> --}}
                            <textarea type="text" class="form-control" id="nome_inglese" wire:model="nome_inglese"></textarea>
                            @error('nome_inglese')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        @if ($type == 'piatto' || str_contains($type, 'modifica_piatto'))

                            <div class="form-group mt-2">
                                <label for="descrizione_inglese">Descrizione Inglese</label>
                                <textarea type="text" class="form-control" id="descrizione_inglese" wire:model="descrizione_inglese"></textarea>
                                @error('descrizione_inglese')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-2">
                                <label for="prezzo">Prezzo nel menù</label>
                                <input type="number" step="0.01" class="form-control" id="prezzo" wire:model="prezzo">
                                @error('prezzo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-2">
                                <label>Opzioni</label>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $asporto }}" wire:model.live="asporto">
                                    <label class="form-check-label d-flex align-items-center ms-2">
                                        Piatto da asporto
                                    </label>
                                </div>
                                @error('asporto')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                @if ($asporto)
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="checkbox" value="{{ $solo_asporto }}" wire:model="solo_asporto">
                                        <label class="form-check-label d-flex align-items-center ms-2">
                                            Piatto esclusivamente da asporto
                                        </label>
                                    </div>
                                    @error('solo_asporto')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group mt-2">
                                        <label for="prezzo_asporto">Prezzo nel menù da asporto</label>
                                        <input type="number" step="0.01" class="form-control" id="prezzo_asporto" wire:model="prezzo_asporto">
                                        @error('prezzo_asporto')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $show_desc }}" wire:model="show_desc">
                                    <label class="form-check-label d-flex align-items-center ms-2">
                                        Mostra descrizione nel menù
                                    </label>
                                </div>
                                @error('surgelato')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group mt-2">
                                <label>Caratteristiche</label>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $surgelato }}" wire:model="surgelato">
                                    <label class="form-check-label d-flex align-items-center ms-2">
                                        <i class="bi bi-snow2 me-2"></i>- Congelato
                                    </label>
                                </div>
                                @error('surgelato')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-2">
                                <label>Allergeni</label>
                                @foreach ($allergeni as $allergene)
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="checkbox" value="{{ $allergene->id }}" wire:model="selectedAllergeni">
                                        <label class="form-check-label d-flex align-items-center ms-2">
                                            <div class="invert-image me-1" style="background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png'); height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center;"></div>
                                            - {{ $allergene->nome_italiano }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('selectedAllergeni')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        @if ($type == 'piatto' && !$categoria_id && !$sottoSottocategoria_id)
                            <div class="form-group mt-2">
                                <label for="sottocategoria_id">Sottocategoria</label>
                                <select id="sottocategoria_id" class="form-control" wire:model="sottocategoria_id">
                                    <option value="">Seleziona Sottocategoria</option>
                                    @foreach (App\Models\SottocategoriaMenu::all() as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nome_italiano }}</option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @elseif ($type == 'piatto' && !$sottocategoria_id && !$categoria_id)
                            <div class="form-group mt-2">
                                <label for="sottoSottocategoria_id">Sotto-Sottocategori</label>
                                <select id="sottoSottocategoria_id" class="form-control" wire:model="sottoSottocategoria_id">
                                    <option value="">Seleziona Sotto-Sottocategoria</option>
                                    @foreach (App\Models\SottoSottocategoriaMenu::all() as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nome_italiano }}</option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @elseif ($type == 'piatto' && !$sottocategoria_id && !$sottoSottocategoria_id)
                            <div class="form-group mt-2">
                                <label for="categoria_id">Categoria</label>
                                <select id="categoria_id" class="form-control" wire:model="categoria_id">
                                    <option value="">Seleziona Categoria</option>
                                    @foreach (App\Models\CategoriaMenu::all() as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nome_italiano }}</option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </form>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                @if (str_contains($type, 'elimina'))

                    @if ($type == 'elimina_piatto_categoria')
                        <button type="button" class="btn btn-danger" wire:click="deletePiattoCategoria">Elimina Piatto Categoria</button>
                    @elseif ($type == 'elimina_piatto_sottocategoria')
                        <button type="button" class="btn btn-danger" wire:click="deletePiattoSottocategoria">Elimina Piatto Sottocategoria</button>
                    @elseif ($type == 'elimina_piatto_sotto_sottocategoria')
                        <button type="button" class="btn btn-danger" wire:click="deletePiattoSottoSottoCategory">Elimina Piatto Sotto-Sottocategoria</button>
                    @elseif ($type == 'elimina_categoria')
                        <button type="button" class="btn btn-danger" wire:click="deleteCategory">Elimina Categoria</button>
                    @elseif ($type == 'elimina_sottocategoria')
                        <button type="button" class="btn btn-danger" wire:click="deleteSottoCategory">Elimina Sottocategoria</button>
                    @elseif ($type == 'elimina_sotto_sottocategoria')
                        <button type="button" class="btn btn-danger" wire:click="deleteSottoSottoCategory">Elimina Sotto-Sottocategoria</button>
                    @endif
                @else
                    <button type="button" class="btn btn-primary" wire:click="save">Salva</button>
                @endif
            </div>
        </div>
    </div>

    <style>
        #nome_italiano,
        #nome_inglese,
        #descrizione_italiano,
        #descrizione_inglese {
            min-height: 50px;
            /* Altezza minima per la textarea */
            box-sizing: border-box;
            /* Include il padding e il bordo nel calcolo dell'altezza */
            width: 100%;
            /* Occupa tutta la larghezza disponibile */
        }
    </style>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('show-modal', () => {
                const modalElement = document.getElementById('addElementModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });

            Livewire.on('hide-modal', () => {
                const modalElement = document.getElementById('addElementModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                }
            });

            Livewire.on('uploadPhotoPreview', (e) => {
                $('#photo_url').trigger('click');
            });


            // Funzione per gestire l'evento 'keydown' su Enter
            function handleEnterKey(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();

                    const textarea = event.target;
                    const cursorPosition = textarea.selectionStart;

                    textarea.value = textarea.value.substring(0, cursorPosition) + '\n' + textarea.value.substring(cursorPosition);

                    textarea.selectionStart = textarea.selectionEnd = cursorPosition + 1;
                }
            }

            // Funzione per auto-ridimensionare la textarea
            function autoResizeTextarea(textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            }

            // Aggiungi gli event listeners a tutte le textarea
            function addEventListenersToTextareas(textareaIds) {
                textareaIds.forEach(function(id) {
                    const textarea = document.getElementById(id);

                    if (textarea) {
                        // Aggiunge l'evento keydown
                        textarea.addEventListener('keydown', handleEnterKey);

                        // Aggiunge l'evento input per l'auto-ridimensionamento
                        textarea.addEventListener('input', function() {
                            autoResizeTextarea(this);
                        });

                        // Inizializza l'altezza della textarea al caricamento della pagina
                        autoResizeTextarea(textarea);
                    }
                });
            }

            // Lista degli ID delle textarea da gestire
            const textareaIds = [
                'nome_italiano',
                'nome_inglese',
                'descrizione_italiano',
                'descrizione_inglese'
            ];

            // Applica gli event listeners a tutte le textarea
            addEventListenersToTextareas(textareaIds);

        });
    </script>
@endpush
