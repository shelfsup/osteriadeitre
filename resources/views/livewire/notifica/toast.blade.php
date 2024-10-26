<div>
    @if (Session::has('success'))
        <!-- Popup di notifica per il successo -->
        <div class="notification">
            {{ Session::get('success') }}
            <!-- Pulsante di chiusura del popup -->
            <span class="close-btn-custom">&times;</span>
        </div>
    @endif

    @if (Session::has('error'))
        <!-- Popup di notifica per l'errore -->
        <div class="notification" style="background-color: #dc3545;"> <!-- Cambia colore di sfondo per l'errore -->
            {{ Session::get('error') }}
            <!-- Pulsante di chiusura del popup -->
            <span class="close-btn-custom">&times;</span>
        </div>
    @endif
</div>

@push('scripts')
    <script>
            Livewire.on('notifica', (event) => {
                setTimeout(() => {
                    // Mostra le notifiche
                    $('.notification').show();

                    // Chiudi automaticamente le notifiche dopo 3 secondi
                    setTimeout(function() {
                        $('.notification').fadeOut('slow', function() {
                            $(this).remove(); // Rimuovi la notifica dal documento
                        });
                    }, 3000);

                    // Chiudi manualmente le notifiche quando si clicca sul pulsante di chiusura
                    $('.close-btn-custom').click(function() {
                        $(this).parent().fadeOut('slow', function() {
                            $(this).remove(); // Rimuovi la notifica dal documento
                        });
                    });
                }, 1000);

            });
    </script>
@endpush
