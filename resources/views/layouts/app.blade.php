<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __( config('app.name', 'Snackin') ) }}</title>

    {{-- tes assets (pas de Vite) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-pink-100">
    <div id="app">
        <main class="py-0">
            @yield('content')
        </main>
    </div>

    <!-- Sélecteur de langue en haut -->
    <div style="position: fixed; top: 10px; right: 20px; z-index: 1000;">
        @include('components.language-switcher')
    </div>
</body>
</html>
