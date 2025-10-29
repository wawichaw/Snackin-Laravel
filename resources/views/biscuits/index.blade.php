@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/biscuits.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/background.css') }}">

<div class="snackin-background"></div>

@php
  // Montrer les contrôles d'administration uniquement pour les admins
  $showAdmin = Auth::check() && ( (isset(Auth::user()->is_admin) && Auth::user()->is_admin) || (isset(Auth::user()->role) && strtoupper(Auth::user()->role) === 'ADMIN') );

  // Liste fermée de saveurs
  $allowedSaveurs = ['original','chocolat','caramel','vanille','smores','oreo'];

  // Map emoji par saveur
  $emojiMap = [
    'original'=>'🍪',
    'chocolat'=>'🍫',
    'caramel'=>'🍮',
    'vanille'=>'🌼',
    'smores'=>'🔥🍫',
    'oreo'=>'🍪',
  ];

  // Si ta BDD utilise des IDs plutôt que des noms
  $idToSaveur = [
    1=>'original', 2=>'chocolat', 3=>'caramel',
    4=>'vanille', 5=>'smores', 6=>'oreo',
  ];
@endphp

{{-- NAVIGATION / HEADER --}}
<div class="snk-nav">
  <div class="snk-container">
    <a class="snk-logo" href="{{ route('home') }}">
      <img src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="{{ __('Snackin logo') }}" style="width:36px;height:36px;object-fit:contain">
      <strong>{{ __('Snackin\'') }}</strong>
    </a>
    <span class="snk-badge">{{ __('Fait à Montréal') }}</span>

    <div class="snk-spacer"></div>
    <a href="{{ route('home') }}">{{ __('Accueil') }}</a>
    <a href="{{ route('biscuits.index') }}" aria-current="page">{{ __('Biscuits') }}</a>

    @auth
      @if(Auth::user()->is_admin || (isset(Auth::user()->role) && strtoupper(Auth::user()->role) === 'ADMIN'))
        <a href="{{ route('saveurs.index') }}">{{ __('Saveurs') }}</a>
        <a href="{{ route('commandes.index') }}">{{ __('Commandes (admin)') }}</a>
      @else
        <a href="{{ route('commandes.create') }}">{{ __('Commander') }}</a>
        <a href="{{ route('mes.commandes') }}">{{ __('Mes commandes') }}</a>
      @endif
    @endauth

    <a href="{{ route('about') }}">{{ __('À propos') }}</a>


    <div class="snk-spacer"></div>
    @auth
      <span class="snk-greeting">{{ __('Bonjour,') }} {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter') }}</a>
      </form>
    @else
      <a href="{{ route('login') }}" style="margin-right:10px;">{{ __('Se connecter') }}</a>
      @if (Route::has('register')) <a href="{{ route('register') }}">{{ __('S\'inscrire') }}</a> @endif
    @endauth
  </div>
</div>

{{-- CONTENU PRINCIPAL --}}
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ __('Nos Biscuits') }}</h1>
    @if($showAdmin)
      <a href="{{ route('biscuits.create') }}" class="btn btn-primary">{{ __('+ Ajouter') }}</a>
    @endif
  </div>

  {{-- RECHERCHE ET FILTRES --}}
  <form method="GET" action="{{ route('biscuits.index') }}" class="search-filters">
    <div class="search-box">
      <input type="text" 
             id="searchBiscuit"
             name="search"
             placeholder="{{ __('Rechercher un biscuit...') }}"
             value="{{ request('search') }}"
             autocomplete="off"
             data-search-url="{{ route('biscuits.search') }}">
      <div class="search-suggestions" id="searchSuggestions"></div>
    </div>

    <select name="saveur" class="filter-select" onchange="this.form.submit()">
      <option value="">{{ __('Toutes les saveurs') }}</option>
      @foreach($allowedSaveurs as $saveur)
        <option value="{{ strtolower($saveur) }}" {{ request('saveur') == strtolower($saveur) ? 'selected' : '' }}>
          {{ $emojiMap[strtolower($saveur)] }} {{ ucfirst($saveur) }}
        </option>
      @endforeach
    </select>

    <select name="prix" class="filter-select" onchange="this.form.submit()">
      <option value="">{{ __('Trier par prix') }}</option>
      <option value="asc" {{ request('prix') == 'asc' ? 'selected' : '' }}>{{ __('Prix croissant 💰') }}</option>
      <option value="desc" {{ request('prix') == 'desc' ? 'selected' : '' }}>{{ __('Prix décroissant 💰') }}</option>
    </select>
  </form>

  @if($biscuits->isEmpty())
    <div class="alert alert-info">
      {{ __('Aucun biscuit pour l\'instant. Revenez bientôt — nouvelle fournée en préparation!') }}
    </div>
  @else
    <div class="biscuits-grid">
      @foreach($biscuits as $biscuit)
        @php
          $saveurName = $biscuit->saveur ? strtolower($biscuit->saveur->nom_saveur) : null;
          $emoji = $emojiMap[$saveurName] ?? '🍪';
        @endphp

        <div class="biscuit-card">
          {{-- Bulle emoji qui dépasse --}}
          <div class="flavor-emoji" title="{{ $saveurName ? ucfirst($saveurName) : 'Saveur' }}">
            {{ $emoji }}
          </div>

          {{-- Image du biscuit --}}
          <div class="biscuit-image">
            @if(!empty($biscuit->image))
              <img src="{{ asset('Contenu/img/'.$biscuit->image) }}" alt="{{ $biscuit->nom_biscuit ?? $biscuit->nom }}">
            @else
              <span class="no-image">{{ __('Aucune image') }}</span>
            @endif
          </div>

          {{-- Infos du biscuit --}}
          <div class="biscuit-info">
            <h5 class="card-title">{{ $biscuit->nom_biscuit ?? $biscuit->nom }}</h5>

            @if($saveurName)
              <div class="saveur-chip">
                <span class="emoji">{{ $emoji }}</span>
                {{ ucfirst($saveurName) }}
              </div>
            @endif

            @if(!empty($biscuit->description))
              <p class="desc">{{ $biscuit->description }}</p>
            @endif

            <p class="card-text price">{{ number_format($biscuit->prix, 2) }} $</p>
          </div>

          {{-- Actions admin --}}
          @if($showAdmin)
            <div class="card-actions">
              <a href="{{ route('biscuits.edit', $biscuit) }}" class="btn btn-sm btn-outline-secondary">{{ __('Modifier') }}</a>
              <form action="{{ route('biscuits.destroy', $biscuit) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Supprimer ce biscuit ?') }}')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">{{ __('Supprimer') }}</button>
              </form>
            </div>
          @endif
        </div>
      @endforeach
    </div>
  @endif
</div>

<footer>
  <small>{{ __('© :year Snackin — Fait avec Laravel & beaucoup d\'amour.', ['year' => date('Y')]) }}</small>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchBiscuit');
    const suggestions = document.getElementById('searchSuggestions');
    
    if (!searchInput || !suggestions) {
        return;
    }
    
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            suggestions.classList.remove('visible');
            return;
        }

        searchTimeout = setTimeout(() => {
            const searchUrl = searchInput.getAttribute('data-search-url');
            
            fetch(`${searchUrl}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        suggestions.innerHTML = data.map(item => `
                            <div class="suggestion-item" data-id="${item.id}">
                                <span class="emoji">${item.emoji}</span>
                                <div class="details">
                                    <div class="name">${item.nom_biscuit}</div>
                                    <div class="saveur">${item.nom_saveur}</div>
                                </div>
                            </div>
                        `).join('');
                        suggestions.classList.add('visible');
                    } else {
                        suggestions.innerHTML = '<div class="suggestion-item" style="color: var(--ink-soft);">{{ __('Aucun résultat trouvé') }}</div>';
                        suggestions.classList.add('visible');
                    }
                })
                .catch(error => {
                    suggestions.classList.remove('visible');
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.classList.remove('visible');
        }
    });

    suggestions.addEventListener('click', function(e) {
        const item = e.target.closest('.suggestion-item');
        if (item) {
            searchInput.value = item.querySelector('.name').textContent.trim();
            searchInput.closest('form').submit();
        }
    });
});
</script>
@endsection
