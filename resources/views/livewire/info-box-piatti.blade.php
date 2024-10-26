<div>
    <div class="d-flex flex-column gap-3 align-items-center py-5 container-show-piatto @if ($this->showPiatto) show @endif ">
        <button id="closePiatto" class="closePiatto d-flex align-items-center justify-content-center" style="height: 2rem; width: 2rem; position: absolute; right: 1rem; top:1rem; border:none; border-radius: 18px; background-color: var(--bg-button-3); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; color: var(--color-text) !important;">X</button>

        @if ($showPhoto)
            <div class="d-flex justify-content-center">
                <div style="border-radius: 13px; height: 35vh; width: 35vh; background-image: url('{{ Storage::url($showPhoto) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
            </div>
        @endif

        <h2 class="piatto-nome fs-3">
            {!! $showNome !!}
            @if ($showSurgelato)
                <i class="bi bi-snow2" style="color: black !important"></i>
            @endif
        </h2>

        <p class="m-0 btn btn-primary fs-5 prezzo-infobox">
            @if (fmod($showPrezzo, 1) == 0)
                {{ number_format($showPrezzo, 0, ',', '.') }}€
            @else
                {{ number_format($showPrezzo, 2, ',', '.') }}€
            @endif
        </p>

        @if ($showDescrizione)
            <div class="mx-md-5 mx-sm-3 mx-2 px-md-5 px-sm-3 px-2">
                <p class="m-0 fs-6 text-center">
                    {!! $showDescrizione !!}
                </p>
            </div>
        @endif

        @if ($showAllergeni)
            <p class="m-0 fs-6 fw-bold">
                ALLERGENI
            </p>
            <div class="d-flex flex-wrap gap-5 justify-content-center">
                @foreach ($showAllergeni as $allergene)
                    @php
                        $allergene = \App\Models\Allergeni::findOrFail($allergene);
                    @endphp
                    <button data-bs-toggle="modal" data-bs-target="#allergeniModal" class="" style="height: 1.5rem; width: 1.5rem; background-repeat: no-repeat; background-size: contain; background-position: center; border: none; background-color: transparent; background-image: url('/svg/{{ strtolower(str_replace(' ', '_', $allergene->nome_italiano)) }}.png');"></button>
                @endforeach
            </div>
        @endif



    </div>
    <div class="overlay @if ($this->showPiatto) show @endif"></div>
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('body').on('click', '.tabella-piatto', function() {
                var piattoId = $(this).data('piatto-id');
                var lingua = $(this).attr('data-lingua');
                var asporto = $(this).data('asporto');

                console.log(lingua);
                Livewire.dispatch('showPiatto', {
                    piattoId: piattoId,
                    lang: lingua,
                    prezzo_asporto: asporto
                });
            });

            $('body').on('click', '.tabella-piatto-sottocategoria', function() {
                var piattoId = $(this).data('piatto-id');
                var lingua = $(this).attr('data-lingua');
                var asporto = $(this).data('asporto');

                Livewire.dispatch('showPiattoSottocategoria', {
                    piattoId: piattoId,
                    lang: lingua,
                    prezzo_asporto: asporto
                });
            });

            $('body').on('click', '.tabella-piatto-sotto-sottocategoria', function() {
                var piattoId = $(this).data('piatto-id');
                var lingua = $(this).attr('data-lingua');
                var asporto = $(this).data('asporto');

                Livewire.dispatch('showPiattoSottoSottocategoria', {
                    piattoId: piattoId,
                    lang: lingua,
                    prezzo_asporto: asporto
                });
            });


            Livewire.on('openInfoPiatto', (e) => {
                $('.container-show-piatto').toggleClass('show');
                $('.overlay').toggleClass('show');

            });

            $('body').on('click', '.closePiatto', function() {
                $('.container-show-piatto').toggleClass('show');
                $('.overlay').toggleClass('show');

                setTimeout(() => {
                    Livewire.dispatch('resetPiatto', {});
                }, 300);
            });

        });
    </script>
@endpush
