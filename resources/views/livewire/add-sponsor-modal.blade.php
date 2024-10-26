<div class="modal fade @if ($showModal) show @endif" id="addSponsorModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true" style="{{ $showModal ? 'display: block;' : 'display: none;' }}">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--bg-White) !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">
                    @if (str_contains($type, 'elimina'))
                        Conferma Eliminazione
                    @elseif (str_contains($type, 'modifica'))
                        Modifica {{ ucfirst(explode('_', $type)[1]) }}
                    @else
                        Aggiungi {{ ucfirst($type == "aggiungi_sponsor" ? 'Sponsor' : '') }}
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
                                <input class="d-none @error('photo_url') is-invalid @enderror" id="photo_sponsor" name="photo_url" type="file" wire:model="photo_url" />
                                <div style="position: relative; background-color: var(--bg-lightgreen2); border-radius: 13px;">
                                    @if ($photoPreview)
                                        <div class="d-flex justify-content-center align-items-center immagine-profilo border-Gray-5 bg-Trasparent " style=" @if ($this->inverti) filter: invert(100%); -webkit-filter: invert(100%); @endif border-radius: 13px; height: 15vh !important; width: 15vh !important; background-image: url({{ $photoPreview }});background-position: center;background-repeat: no-repeat; background-size: contain;">

                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center align-items-center immagine-profilo border-Gray-5 bg-Trasparent " style=" @if ($this->inverti) filter: invert(100%); -webkit-filter: invert(100%); @endif border-radius: 13px; height: 15vh !important; width: 15vh !important;">
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
                                <button id="previewImmagine" type="button" class="btn btn-primary mt-2 mb-3" onclick="Livewire.dispatch('uploadSponsorPhotoPreview')" wire:click="clearPhotoPreview">
                                    <!-- Aggiungi l'evento wire:click per cancellare l'anteprima -->
                                    <i class="bi bi-pencil-fill" style="padding:0 !important;"></i> Carica una immagine
                                </button>
                            </div>
                        </div>




                        <div class="form-group mt-2">
                            <label for="nome_sponsor">Nome Sponsor*</label>
                            <input type="text" class="form-control" id="nome_sponsor" wire:model="nome_sponsor">
                            @error('nome_sponsor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="link_sponsor">Link Sponsor</label>
                            <input type="text" class="form-control" id="link_sponsor" wire:model="link_sponsor">
                            @error('link_sponsor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label>Aspetto Immagine</label>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="checkbox" value="{{ $inverti }}" wire:model.live="inverti" @if ($this->inverti) checked @endif>
                                <label class="form-check-label d-flex align-items-center ms-2">
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
                <button type="button" class="btn {{ $type == 'aggiungi_sponsor' ? 'btn-primary' : ($type == 'modifica_sponsor' ? 'btn-primary' : 'btn-danger') }}" wire:click="{{ $type == 'aggiungi_sponsor' ? 'save' : ($type == 'modifica_sponsor' ? 'save' : 'deleteSponsor') }}">
                    {{ $type == 'aggiungi_sponsor' ? 'Aggiungi' : ($type == 'modifica_sponsor' ? 'Salva' : 'Elimina') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('show-modal-sponsor', () => {
                const modalElement = document.getElementById('addSponsorModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });

            Livewire.on('hide-modal-sponsor', () => {
                const modalElement = document.getElementById('addSponsorModal');
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

            Livewire.on('uploadSponsorPhotoPreview', (e) => {
                $('#photo_sponsor').trigger('click');
            });
        });
    </script>
@endpush
