<!-- resources/views/livewire/toast.blade.php -->
<div class="toast-panel">
    @if ($type && $message)
        <div class="toast-item {{ $type }}">
            <div id="toast" class="toast {{ $type }}">
                <label id="close-btn-custom-toast" for="t-{{ $type }}" class="close"></label>
                <h3>{{ ucfirst($type) }}!</h3>
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif
</div>

{{-- DOCUMENTAZIONE UTILIZZO

per dispacciare da un componente livewire utilizzare il seguente formato:

$this->dispatch('notifica',
    toastData: [
        'message' => 'Spesa aggiunta con successo!',
        'type' => 'help', // Può essere 'success', 'error', 'warning', 'help', o altro a tua scelta
        ]
);
------------------------------------------------------------------------------------------------------

per dispacciare lato javascript utilizzare in seguente formato

Livewire.dispatch('notifica', {
    toastData: {
        message: 'Spesa aggiunta con successo!',
        type: 'success' // Può essere 'success', 'error', 'warning', 'help', o altro a tua scelta
    }
});

------------------------------------------------------------------------------------------------------
    --}}

@assets
    @vite(['resources/css/custom-toast.css'])
@endassets

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Livewire.on('notifica', (data) => {
                Livewire.dispatch('showToast', {
                    toastData: data
                });
            });

            Livewire.on('setToast', (data) => {
                setTimeout(() => {
                    let customToast = $('#toast');
                    let closeButton = $('#close-btn-custom-toast');
                    let message = data.message;
                    let type = data.type;
                    let timeoutId;

                    setTimeout(() => {
                        // customToast.addClass('show'); // Aggiungi la classe "show" per visualizzare il toast gradualmente
                        customToast.fadeIn(() => {
                            customToast.addClass('show'); // Aggiungi la classe "show" per visualizzare il toast gradualmente
                            // customToast.removeClass('show'); // Rimuovi la classe "show" dopo il fadeOut
                        });
                    }, 100);


                    function closeToast() {
                        customToast.fadeOut(() => {
                            customToast.removeClass('show'); // Rimuovi la classe "show" dopo il fadeOut
                        });
                    }

                    // Funzione per chiudere il toast con il click del bottone
                    closeButton.on('click', function(e) {
                        closeToast();
                    });


                    // Quando passi sopra al toast, interrompi il timeout
                    customToast.on('mouseenter', function() {
                        clearTimeout(timeoutId);
                    });

                    // Quando esci dal toast, ripristina il timeout per farlo scomparire dopo 4 secondi
                    customToast.on('mouseleave', function() {
                        timeoutId = setTimeout(() => {
                            closeToast();
                        }, 4000);
                    });

                    // Funzione per chiudere il toast con fadeOut dopo 4 secondi
                    timeoutId = setTimeout(() => {
                        closeToast();
                    }, 4000);
                }, 300);



            });

            $(document).ready(function() {
                let toast = $('#toast');
            });
        });
    </script>
@endpush
