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

@php $locale = session()->get('locale', 'fr'); @endphp
<nav style="position: fixed; bottom: 20px; right: 20px;">
<ul class="navbar-nav">
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        @switch($locale)
            @case('en')
            <img src="{{asset('Contenu/img/flag/en.jpg')}}" width="25px"> English
            @break
            @case('fr')
            <img src="{{asset('Contenu/img/flag/fr.png')}}" width="25px"> Français
            @break
            @case('es')
            <img src="{{ asset('Contenu/img/flag/es.png') }}" width="25px"> Español
            @break
            @default
            <img src="{{asset('Contenu/img/flag/fr.jpg')}}" width="25px"> Français
        @endswitch
        <span class="caret"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('lang.switch', 'fr') }}">
            <img src="{{ asset('Contenu/img/flag/fr.png') }}" width="25px"> Français
          </a>
          <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
            <img src="{{ asset('Contenu/img/flag/en.jpg') }}" width="25px"> English
          </a>
          <a class="dropdown-item" href="{{ route('lang.switch', 'es') }}">
            <img src="{{ asset('Contenu/img/flag/es.png') }}" width="25px"> Español
          </a>
        </div>
     </li>
     </ul>
</nav>
</body>

</html>