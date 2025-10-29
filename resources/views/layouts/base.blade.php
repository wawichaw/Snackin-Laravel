<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
    @stack('styles')
  <title>@yield('title', __('Snackin'))</title>
</head>

<body>
  <div id="global">

    <div id="contenu">
      @yield('content')
    </div>
  </div>

<!-- Sélecteur de langue en haut -->
<div style="position: fixed; top: 10px; right: 20px; z-index: 1000;">
    @include('components.language-switcher')
</div>
</body>

</html>