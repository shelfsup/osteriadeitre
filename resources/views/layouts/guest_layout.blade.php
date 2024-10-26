<!doctype html>
<html lang="it" data-bs-theme="auto" data-theme="light">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, user-scalable=0">

    <meta name="apple-mobile-web-app-status-bar" content="#121212">
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


    @vite(['resources/js/app.js', 'resources/sass/app.scss', 'resources/css/theme_settings.css'])
    {{-- CSS PER I CAROSELLI NELLA HOME DEL RISTORATORE --}}

    @livewireStyles
    {{-- @livewireScripts --}}

    @yield('header-script')


    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    @yield('content')



    @livewireScripts

    {{-- importo jquery e tutti i file javascript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
    @yield('footer-scripts')
    @vite(['resources/js/app.js'])
</body>

</html>
