<!doctype html>
<html lang="it" data-bs-theme="auto" data-theme="light">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, user-scalable=0">
    <meta name="apple-mobile-web-app-status-bar" content="#0b0b0b">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Il Mio Menù</title>

    <link rel="manifest" href="/manifest.json" crossorigin="use-credentials">
    {{-- <link rel="manifest" href="/build/manifest.webmanifest"> --}}
    {{-- <script src="/build/registerSW.js"></script> --}}

    <!-- FONT NUNITO -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo:ital@1&family=Montserrat:wght@100;200;300;400;500;600&family=Nunito:wght@200;300;400;500;700&display=swap" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}


    <link rel="apple-touch-icon" sizes="16x16" href="{{ url('/pwa/icons/ios/16.png') }}">
    <link rel="apple-touch-icon" sizes="20x20" href="{{ url('/pwa/icons/ios/20.png') }}">
    <link rel="apple-touch-icon" sizes="29x29" href="{{ url('/pwa/icons/ios/29.png') }}">
    <link rel="apple-touch-icon" sizes="32x32" href="{{ url('/pwa/icons/ios/32.png') }}">
    <link rel="apple-touch-icon" sizes="40x40" href="{{ url('/pwa/icons/ios/40.png') }}">
    <link rel="apple-touch-icon" sizes="50x50" href="{{ url('/pwa/icons/ios/50.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('/pwa/icons/ios/57.png') }}">
    <link rel="apple-touch-icon" sizes="58x58" href="{{ url('/pwa/icons/ios/58.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('/pwa/icons/ios/60.png') }}">
    <link rel="apple-touch-icon" sizes="64x64" href="{{ url('/pwa/icons/ios/64.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('/pwa/icons/ios/72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/pwa/icons/ios/76.png') }}">
    <link rel="apple-touch-icon" sizes="80x80" href="{{ url('/pwa/icons/ios/80.png') }}">
    <link rel="apple-touch-icon" sizes="87x87" href="{{ url('/pwa/icons/ios/87.png') }}">
    <link rel="apple-touch-icon" sizes="100x100" href="{{ url('/pwa/icons/ios/100.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('/pwa/icons/ios/114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('/pwa/icons/ios/120.png') }}">
    <link rel="apple-touch-icon" sizes="128x128" href="{{ url('/pwa/icons/ios/128.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('/pwa/icons/ios/144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/pwa/icons/ios/152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ url('/pwa/icons/ios/167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/pwa/icons/ios/180.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ url('/pwa/icons/ios/192.png') }}">
    <link rel="apple-touch-icon" sizes="256x256" href="{{ url('/pwa/icons/ios/256.png') }}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{ url('/pwa/icons/ios/512.png') }}">
    <link rel="apple-touch-icon" sizes="1024x1024" href="{{ url('/pwa/icons/ios/1024.png') }}">

    <link href="{{ url('/pwa/icons/ios/1024.png') }}" sizes="1024x1024" rel="apple-touch-startup-image">
    <link href="{{ url('/pwa/icons/ios/512.png') }}" sizes="512x512" rel="apple-touch-startup-image">
    <link href="{{ url('/pwa/icons/ios/256.png') }}" sizes="256x256" rel="apple-touch-startup-image">
    <link href="{{ url('/pwa/icons/ios/192.png') }}" sizes="192x192" rel="apple-touch-startup-image">


    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/sass/app.scss', 'resources/css/theme_settings.css'])
    {{-- CSS PER I CAROSELLI NELLA HOME DEL RISTORATORE --}}
    @livewireStyles
    {{-- @livewireScripts --}}

    @yield('header-script')

    {{-- @vite(['resources/css/appCss/theme_settings.css']) --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @media (min-width: 1201px) {
            .nopcshow {
                display: none !important;
            }
        }

        @media (max-width: 1201px) {
            .sidebar-pc {
                display: none !important;
            }

            .navbar-expand-lg {
                display: none !important;
            }

            .nopcshow {
                display: block;
            }
        }
    </style>

    <style>
        body {
            display: none;
            opacity: 0;
        }

        .preloader-container {
            background: var(--bg-body);
            position: relative;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 99999;
            display: block;
            width: 100%;
            height: 100%;
        }

        #preloader-custom {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        #loader-custom {
            display: block;
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: var(--loader-custom);
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        #loader-custom:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: var(--loader-custom-before);
            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }

        #loader-custom:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: var(--loader-custom-after);
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }

        .content-container {
            opacity: 0;
            transition: opacity 0.5s;
            /* add CSS transition for fade-in effect */
        }

        .preloader-container.fade-out {
            opacity: 0;
            transition: opacity 0.5s;
            /* add CSS transition for fade-out effect */
        }

        [data-theme="light"] .invert-image-light {
            filter: invert(100%);
            -webkit-filter: invert(100%);
        }

        .tron-filter {
            stroke-width: 5;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="overflow-hidden">
    {{-- NAVBAR PHONE --}}
    @livewire('navbar.mobile-navbar')

    {{-- <div class="preloader-container">
        <div id="preloader-custom">
            <div id="loader-custom"></div>
        </div>
    </div> --}}
    <div class="preloader-container">
        <div id="preloader-custom">
            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%">
                <div class="d-flex flex-column align-items-center justify-content-center gap-3">
                    {{-- PIUMA --}}
                    <div id="immagine_logo_caricamento" style="background-image: var(--background-image-logo);"></div>

                </div>
                <div id="loader-custom"></div>
            </div>
        </div>
    </div>

    <div class="d-flex w-100" style="height: 100%;">
        {{-- SIDEBAR --}}
        <div class="d-flex align-items-center sidebar-pc" style="height: 100%;">
            @livewire('navbar.pc-sidebar')
        </div>

        <div class="d-flex flex-column w-100" style="position: relative;">

            @livewire('navbar.pc-navbar')

            <main class="content-container overflow-y-auto mb-md-2 mb-5 pb-md-2 pb-5" style="height: 100%; opacity: 0;">
                @yield('content')
            </main>

        </div>
        {{-- NAVBAR MAIN --}}



    </div>


    @livewire('toast.toast')

    @livewireScripts

    {{-- importo jquery e tutti i file javascript --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.min.js"></script>

    @yield('footer-scripts')

    @stack('scripts')

    <script>
        // Funzione per gestire il fadeout del body e il fadein del preloader prima del reload della pagina
        window.addEventListener('beforeunload', function() {
            // Nascondi gradualmente il body
            $('body').animate({
                opacity: 0
            }, 200);
        });


        document.addEventListener("DOMContentLoaded", (event) => {
            $('body').animate({
                opacity: 1
            }, 500);


            $('.preloader-container').fadeIn(500);


        });

        document.addEventListener("readystatechange", (event) => {
            if (document.readyState == 'complete') {
                $('.preloader-container').fadeOut(2000, function() {

                    $('.content-container').animate({
                        opacity: 1
                    }, 100);

                });
            };
        });

        // document.addEventListener("DOMContentLoaded", (event) => {
        //     Echo.channel('system-maintenance')
        //         .listen('SystemMaintenanceEvent', (event) => {
        //             Livewire.dispatch('showModal', {
        //                 modalData: {
        //                     title: event.title,
        //                     message: event.message
        //                 }
        //             });
        //         });
        // });
    </script>


</body>

</html>
