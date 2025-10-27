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
    <header>
      <a href="{{ url('/') }}">
        <h1 id="titreBlog">Snackin</h1>
      </a>
      <p>Bienvenue dans notre site!</p>
      <div class="user-bar">
        @auth
          <span>Bonjour, <strong>{{ Auth::user()->name }}</strong></span>
          &nbsp;
          <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-white"
              style="background: transparent; border: 1px solid white; color: white; padding: 5px 10px; cursor: pointer;">Se
              déconnecter</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-white">Se connecter</a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-white" style="margin-left: 10px;">S'inscrire</a>
          @endif
        @endauth
      </div>
    </header>

    <div id="contenu">
      @yield('content')
    </div>

    <nav class="navigation">
      <a href="{{ url('/') }}" class="btn btn-primary">Accueil</a>
      <a href="{{ route('biscuits.index') }}" class="btn btn-success">Biscuit</a>
      @if(Auth::check() && Auth::user()->is_admin)
        <a href="{{ route('commandes.index') }}" class="btn btn-warning">Admin Commandes</a>
      @else
        <a href="{{ url('commandes') }}" class="btn btn-warning">Commandes</a>
      @endif
      <a href="{{ url('about') }}" class="btn btn-secondary">À propos</a>
    </nav>

    <footer id="piedSite">
      Blog réalisé avec PHP et Laravel.
    </footer>
  </div>
</body>

</html>