<div class="modal fade @if ($showModal) show @endif" id="addElementModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--bg-White) !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @if (str_contains($type, 'elimina'))
                        Conferma Eliminazione
                    @elseif (str_contains($type, 'modifica'))
                        Modifica {{ ucfirst(explode('_', $type)[1]) }}
                    @else
                        Aggiungi {{ ucfirst($type == "aggiungi_social" ? 'Social' : '') }}
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (str_contains($type, 'elimina'))
                    <p>Sei sicuro di voler eliminare questo elemento?</p>
                @else
                    <form>


                        <div class="mt-3">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <input class="d-none @error('photo_url') is-invalid @enderror" id="photo_url" name="photo_url" type="file" wire:model="photo_url" />
                                <div style="position: relative; background-color: var(--bg-lightgreen2); border-radius: 13px;">
                                    @if ($photoPreview)
                                        <div class="d-flex justify-content-center align-items-center immagine-profilo border-Gray-5 bg-Trasparent " style=" @if ($this->inverti_img_social) filter: invert(100%); -webkit-filter: invert(100%); @endif border-radius: 13px; height: 15vh !important; width: 15vh !important; background-image: url({{ $photoPreview }});background-position: center;background-repeat: no-repeat; background-size: cover;">

                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center align-items-center immagine-profilo border-Gray-5 bg-Trasparent " style=" @if ($this->inverti_img_social) filter: invert(100%); -webkit-filter: invert(100%); @endif border-radius: 13px; height: 15vh !important; width: 15vh !important;">
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




                        <div class="form-group mt-2">
                            <label for="nome_social">Nome Social</label>
                            <input type="text" class="form-control" id="nome_social" wire:model="nome_social">
                            @error('nome_social')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="link_profilo">Link Social</label>
                            <input type="text" class="form-control" id="link_profilo" wire:model="link_profilo">
                            @error('link_profilo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label>Aspetto Immagine</label>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="checkbox" id="inverti_img_social" value="{{ $this->inverti_img_social ? true : false }}" wire:model.live="inverti_img_social" @if($inverti_img_social) checked @endif >
                                <label class="form-check-label d-flex align-items-center ms-2" for="inverti_img_social">
                                     Inverti i colori dell'immagine
                                </label>
                            </div>
                            @error('surgelato')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn {{ $type == 'aggiungi_social' ? 'btn-primary' : ($type == 'modifica_social' ? 'btn-primary' : 'btn-danger') }}" wire:click="{{ $type == 'aggiungi_social' ? 'save' : ($type == 'modifica_social' ? 'save' : 'deleteSocial') }}">
                    {{ $type == 'aggiungi_social' ? 'Aggiungi' : ($type == 'modifica_social' ? 'Salva' : 'Elimina') }}
                </button>
            </div>
        </div>
    </div>
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
        });
    </script>
@endpush
