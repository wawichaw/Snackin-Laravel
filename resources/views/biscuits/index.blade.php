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
      <img src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="Snackin logo" style="width:36px;height:36px;object-fit:contain">
      <strong>Snackin'</strong>
    </a>
    <span class="snk-badge">{{ __('Fait à Montréal') }}</span>

    <div class="snk-spacer"></div>
    <a href="{{ route('home') }}">Accueil</a>
    <a href="{{ route('biscuits.index') }}" aria-current="page">Biscuits</a>

    @auth
      @if(Auth::user()->is_admin || (isset(Auth::user()->role) && strtoupper(Auth::user()->role) === 'ADMIN'))
        <a href="{{ route('saveurs.index') }}">Saveurs</a>
        <a href="{{ route('commandes.index') }}">Commandes (admin)</a>
      @else
        <a href="{{ route('commandes.create') }}">Commander</a>
        <a href="{{ route('mes.commandes') }}">Mes commandes</a>
      @endif
    @endauth

    <a href="{{ route('about') }}">À propos</a>

    @include('components.language-switcher-nav')

    <div class="snk-spacer"></div>
    @auth
      <span class="snk-greeting">Bonjour, {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Se déconnecter</a>
      </form>
    @else
      <a href="{{ route('login') }}" style="margin-right:10px;">Se connecter</a>
      @if (Route::has('register')) <a href="{{ route('register') }}">S’inscrire</a> @endif
    @endauth
  </div>
</div>

{{-- CONTENU PRINCIPAL --}}
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nos Biscuits</h1>
    @if($showAdmin)
      <a href="{{ route('biscuits.create') }}" class="btn btn-primary">+ Ajouter</a>
    @endif
  </div>

  {{-- RECHERCHE ET FILTRES --}}
  <form method="GET" action="{{ route('biscuits.index') }}" class="search-filters">
    <div class="search-box">
      <input type="text" 
             id="searchBiscuit"
             name="search"
             placeholder="Rechercher un biscuit..."
             value="{{ request('search') }}"
             autocomplete="off">
      <div class="search-suggestions" id="searchSuggestions"></div>
    </div>

    <select name="saveur" class="filter-select" onchange="this.form.submit()">
      <option value="">Toutes les saveurs</option>
      @foreach($allowedSaveurs as $saveur)
        <option value="{{ strtolower($saveur) }}" {{ request('saveur') == strtolower($saveur) ? 'selected' : '' }}>
          {{ $emojiMap[strtolower($saveur)] }} {{ ucfirst($saveur) }}
        </option>
      @endforeach
    </select>

    <select name="prix" class="filter-select" onchange="this.form.submit()">
      <option value="">Trier par prix</option>
      <option value="asc" {{ request('prix') == 'asc' ? 'selected' : '' }}>Prix croissant 💰</option>
      <option value="desc" {{ request('prix') == 'desc' ? 'selected' : '' }}>Prix décroissant 💰</option>
    </select>
  </form>

  @if($biscuits->isEmpty())
    <div class="alert alert-info">
      Aucun biscuit pour l'instant. Revenez bientôt — nouvelle fournée en préparation!
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
              <span class="no-image">Aucune image</span>
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
              <a href="{{ route('biscuits.edit', $biscuit) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
              <form action="{{ route('biscuits.destroy', $biscuit) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce biscuit ?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Supprimer</button>
              </form>
            </div>
          @endif
        </div>
      @endforeach
    </div>
  @endif
</div>

<footer>
  <small>© {{ date('Y') }} Snackin — Fait avec Laravel & beaucoup d’amour.</small>
</footer>
@endsection
