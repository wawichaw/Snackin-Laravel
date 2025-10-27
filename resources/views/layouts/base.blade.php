<!doctype html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
    @stack('styles')
  <title>@yield('title', 'Snackin')</title>
</head>

<body>
  <div id="global">

    <div id="contenu">
      @yield('content')
    </div>

  </div>
</body>

</html>