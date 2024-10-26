<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, user-scalable=0">
    <meta name="apple-mobile-web-app-status-bar" content="#000000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Menù {{ env('APP_RISTORANTE') }}</title>

    <link rel="manifest" href="/manifest_menu.json" crossorigin="use-credentials">
    {{-- <link rel="manifest" href="/build/manifest.webmanifest"> --}}
    {{-- <script src="/build/registerSW.js"></script> --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Slabo+13px&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Slabo+13px&display=swap" rel="stylesheet">

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



    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    @vite(['resources/js/app.js', 'resources/sass/app.scss', 'resources/css/menu_theme_settings.css'])
    <style>
        html {
            overflow: hidden !important;
            height: 100%;
        }

        h1 {
            text-shadow: 1px 1px 17px black;
            font-weight: bold !important;
        }


        .swiper-container {
            width: 100%;
            height: 500px;
        }

        @font-face {
            font-family: 'LavagnaFont';
            src: url('/font/ColoredCrayons-7wPR.ttf') format(truetype);
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'FelixTitlingRegular';
            src: url('/font/Felix Titling Regular.ttf') format(truetype);
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'FelixTitlingRegular', sans-serif;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            font-family: 'LavagnaFont', sans-serif;
        }


    </style>



    @livewireStyles
    {{-- @livewireScripts --}}

    @yield('header-script')


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            display: none;
            opacity: 0;
            height: 100% !important;
        }

        html,
        body {
            /* background-image: var(--bg-body-image);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat; */
            background-color: var(--bg-body) !important;
        }

        .preloader-container {
            /* background-image: var(--bg-body-image); */
            background: #816d54;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
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
            margin-top: 3rem;
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

    @php
        $categorie = App\Models\CategoriaMenu::get();
        $sottoCategorie = App\Models\SottocategoriaMenu::get();
        $sottoSottocategorie = App\Models\SottoSottocategoriaMenu::get();
    @endphp

    @foreach ($categorie as $categoria)
        @foreach ($categoria->piatti as $piatto)
            @if ($piatto->photo)
                <link rel="preload" href="{{ Storage::url($piatto->photo) }}" as="image">
            @endif
        @endforeach
    @endforeach

    @foreach ($sottoCategorie as $sottoCategoria)
        @foreach ($sottoCategoria->piattiSottocategorie as $piatto)
            @if ($piatto->photo)
                <link rel="preload" href="{{ Storage::url($piatto->photo) }}" as="image">
            @endif
        @endforeach
    @endforeach


    @foreach ($sottoSottocategorie as $sottoSottoCategoria)
        @foreach ($sottoSottoCategoria->piattiSottoSottocategorie as $piatto)
            @if ($piatto->photo)
                <link rel="preload" href="{{ Storage::url($piatto->photo) }}" as="image">
            @endif
        @endforeach
    @endforeach

</head>


<body>

    </div>
    <div class="d-none">
        @livewire('toggle.dark-mode')
    </div>



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



    <div class="content-container">
        @yield('content')
    </div>


    {{-- @livewire('info-box-piatti') --}}
    @livewireScripts

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
                $('.preloader-container').fadeOut(3000, function() {

                    $('.content-container').animate({
                        opacity: 1
                    }, 100);
                    // $('html').addClass('overflow-y-auto');
                    $('body').addClass('overflow-y-auto');
                });
            };
            window.scrollTo(0, 1)
        });
    </script>
</body>

</html>
