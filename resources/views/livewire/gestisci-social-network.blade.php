<div class="my-5 px-md-4 px-2">
    <div class="px-3 py-2 d-flex flex-column align-items-center justify-content-center gap-2" style="background-color: var(--bg-White); border-radius: 18px; box-shadow: var(--shadow-2);">
        <h2 class="m-0 text-center fs-md-1 fs-4">Gestisci i tuoi Social Networks</h2>

        <div class="w-100">
            @foreach ($socialNetworks as $social)
                <div class="my-2 px-2 py-1" style="background-color: var(--bg-lightgreen2); border-radius: 13px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-fill">
                            <div class="d-flex align-items-center w-100">
                                <a href="{{ $social->link_profilo }}" target="_blank" class="d-block" style=" @if ($social->inverti) filter: invert(100%); -webkit-filter: invert(100%); @endif background-image: url('{{ Storage::url($social->photo) }}'); background-size: contain; background-position: center; background-repeat: no-repeat; height: 2rem; width: 2rem;"></a>
                                <p class="fs-5 fw-bold m-0 ms-2">{{ $social->nome_social }}</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button wire:click="$dispatch('open-modal', { data: { type: 'modifica_social', social_id: {{ $social->id }} }})" class="btn btn-primary" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button wire:click="toggleEnable({{ $social->id }})" class="btn {{ $social->enable ? 'btn-success' : 'btn-warning' }}" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                <i class="bi {{ $social->enable ? 'bi-patch-check' : 'bi-patch-exclamation' }}"></i>
                            </button>
                            <button wire:click="$dispatch('open-modal', { data: { type: 'elimina_social', social_id: {{ $social->id }} }})" class="btn btn-danger" style="color: var(--color-text) !important; padding: 0 5px;" type="button">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary mt-4" wire:click="addSocial">Aggiungi Social</button>

    </div>

    @livewire('add-social-networks-modal')
</div>
