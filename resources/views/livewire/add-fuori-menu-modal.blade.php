<div class="modal fade @if ($showModal) show @endif" id="addPiattoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--bg-White);">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @if ($piattoId)
                        Modifica Special
                    @elseif ($deletePiatto)
                        Elimina Special
                    @else
                        Aggiungi Special
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($deletePiatto)
                    <p class="fs-5 fw-normal m-0">Sei sicuro di voler eliminare questo elemento?</p>
                @else
                    <form>
                        <div class="form-group">
                            <label for="nome_italiano">Nome Italiano</label>
                            {{-- <input type="text" class="form-control" id="nome_italiano" wire:model="nome_italiano"> --}}
                            <textarea class="form-control" id="nome_italiano" wire:model="nome_italiano"></textarea>
                            @error('nome_italiano')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="descrizione_italiano">Descrizione Italiano</label>
                            <textarea class="form-control" id="descrizione_italiano" wire:model="descrizione_italiano"></textarea>
                            @error('descrizione_italiano')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nome_inglese">Nome Inglese</label>
                            {{-- <input type="text" class="form-control" id="nome_inglese" wire:model="nome_inglese"> --}}
                            <textarea class="form-control" id="nome_inglese" wire:model="nome_inglese"></textarea>
                            @error('nome_inglese')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group my-2">
                            <label for="descrizione_inglese">Descrizione Inglese</label>
                            <textarea class="form-control" id="descrizione_inglese" wire:model="descrizione_inglese"></textarea>
                            @error('descrizione_inglese')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="prezzo">Prezzo</label>
                            <input type="number" step="0.01" class="form-control" id="prezzo" wire:model="prezzo">
                            @error('prezzo')
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

                        <div class="form-group my-2">
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
                    </form>
                @endif

            </div>
            <div class="modal-footer">
                @if ($deletePiatto)
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-danger" wire:click="confirmDeletePiatto">Elimina</button>
                @else
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Salva</button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('show-modal', () => {
                const modalElement = document.getElementById('addPiattoModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });

            Livewire.on('hide-modal', () => {
                const modalElement = document.getElementById('addPiattoModal');
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
