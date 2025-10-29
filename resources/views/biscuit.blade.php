<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <title>{{ __('Snackin — Menu des biscuits') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('Contenu/css/biscuits.css') }}?v={{ @filemtime(public_path('Contenu/css/biscuits.css')) }}">
</head>
<body>

  <div class="biscuits-container">

    {{-- HERO coloré + image --}}
    <section class="biscuits-hero">
      <div class="hero-inner">
        <div class="hero-copy">
          <span class="badge">{{ __('Menu') }}</span>
          <h1>{{ __('Nos biscuits, tout doux ✨') }}</h1>
          <p class="subtitle">{{ __('Croquants dehors, fondants dedans — choisis ton coup de cœur.') }}</p>
          <p class="count">{{ __('Nombre de biscuits :') }} {{ $biscuits->count() }}</p>
        </div>
        <div class="hero-visual">
          <div class="arch"></div>
          <img src="{{ asset('Contenu/img/stack-cookies.png') }}" alt="{{ __('Stack de cookies Snackin') }}" class="stack-float">
        </div>
      </div>
      <div class="sprinkles"></div>
    </section>

    <hr class="section-sep">

    {{-- ALERTES --}}
    @if (isset($error))
      <div class="alert alert-danger">
        <strong>{{ __('Erreur :') }}</strong> {{ $error }}
      </div>
    @endif
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    {{-- LISTE DES BISCUITS (ta logique inchangée) --}}
    @if(isset($biscuits) && method_exists($biscuits,'count') && $biscuits->count() > 0)
      <ul class="biscuits-list">
        @foreach ($biscuits as $biscuit)
          <li class="biscuit-item">
            <span class="biscuit-info">
              <strong>{{ $biscuit->nom_biscuit }}</strong>
              <span class="price">{{ number_format($biscuit->prix, 2) }} $</span>
              @if($biscuit->saveur)
                <span class="saveur">{{ $biscuit->saveur->nom_saveur }}</span>
              @endif
            </span>
          </li>
        @endforeach
      </ul>
    @else
      <div class="empty">
        <p>{{ __('Aucun biscuit trouvé.') }}</p>
      </div>
    @endif

  </div>

  <footer class="page-footer">
    <small>© {{ date('Y') }} {{ __("Snackin — Fait avec Laravel & beaucoup d'amour.") }}</small>
  </footer>

</body>
</html>
