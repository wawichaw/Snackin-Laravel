<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Snackin — Menu des biscuits</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Feuille de style principale --}}
    <link rel="stylesheet" href="{{ asset('Contenu/css/biscuits.css') }}?v={{ file_exists(public_path('Contenu/css/biscuits.css')) ? filemtime(public_path('Contenu/css/biscuits.css')) : time() }}">
</head>

<body>

  <div class="biscuits-container">

      {{-- SECTION HERO --}}
      <div class="biscuits-hero">
          <span class="badge">Menu</span>
          <h1>Notre Menu de Biscuits</h1>
          <p class="subtitle">Croquants dehors, fondants dedans — choisis ton coup de cœur.</p>
          <p class="count">Nombre de biscuits : {{ $biscuits->count() }}</p>
      </div>

      {{-- ALERTES --}}
      @if (isset($error))
          <div class="alert alert-danger">
              <strong>Erreur :</strong> {{ $error }}
          </div>
      @endif

      @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      {{-- LISTE DES BISCUITS --}}
      <ul class="biscuits-list">
          @forelse ($biscuits as $biscuit)
              <li class="biscuit-item">
                  <span class="biscuit-info">
                      <strong>{{ $biscuit->nom_biscuit }}</strong>
                      <span class="price">{{ $biscuit->prix }}$</span>
                      @if($biscuit->saveur)
                          <span class="saveur">{{ $biscuit->saveur->nom_saveur }}</span>
                      @endif
                  </span>
              </li>
          @empty
              <li>Aucun biscuit trouvé.</li>
          @endforelse
      </ul>

  </div>

  {{-- FOOTER --}}
  <footer style="text-align:center; margin:40px 0 24px; color:#6b5d5d;">
      <small>© {{ date('Y') }} Snackin — Fait avec Laravel & beaucoup d’amour.</small>
  </footer>

</body>
</html>
