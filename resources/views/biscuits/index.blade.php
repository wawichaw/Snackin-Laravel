@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/biscuits.css') }}">

@php
  $showAdmin = Auth::check() || app()->environment('local');
@endphp

{{-- NAV / HEADER (inchangé) --}}
<div class="snk-nav">
  <div class="snk-container">
    <a class="snk-logo" href="{{ route('home') }}">
      <img src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="Snackin logo" style="width:36px;height:36px;object-fit:contain">
      <strong>Snackin'</strong>
    </a>
    <span class="snk-badge">Fait à Montréal</span>

    <div class="snk-spacer"></div>
    <a href="{{ route('home') }}">Accueil</a>
    <a href="{{ route('biscuits.index') }}" aria-current="page">Biscuits</a>
    <a href="{{ route('commandes.create') }}">Commander</a>
    <a href="{{ route('saveurs.index') }}">Saveurs</a>
    <a href="{{ route('about') }}">À propos</a>

    <div class="snk-spacer"></div>
    @auth
      <span style="color:#694256; margin-right:12px;">Bonjour, {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="color:#694256; text-decoration:none;">Se déconnecter</a>
      </form>
    @else
      <a href="{{ route('login') }}" style="margin-right:10px;">Se connecter</a>
      @if (Route::has('register')) <a href="{{ route('register') }}">S’inscrire</a> @endif
    @endauth
  </div>
</div>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nos Biscuits</h1>
    @if($showAdmin)
      <a href="{{ route('biscuits.create') }}" class="btn btn-primary">+ Ajouter</a>
    @endif
  </div>

  @if($biscuits->isEmpty())
    <div class="alert alert-info">
      Aucun biscuit pour l'instant. Revenez bientôt — nouvelle fournée en préparation!
    </div>
  @else
    <div class="biscuits-grid">
      @foreach($biscuits as $biscuit)
        <div class="biscuit-card">
          {{-- Image du biscuit --}}
          <div class="biscuit-image">
            @if ($biscuit->image)
              <img src="{{ asset('Contenu/img/'.$biscuit->image) }}" alt="{{ $biscuit->nom_biscuit }}" class="img-fluid rounded">
            @else
              <span class="no-image">Aucune image</span>
            @endif
          </div>

          {{-- Infos du biscuit --}}
          <div class="biscuit-info">
            <h5 class="card-title">{{ $biscuit->nom }}</h5>
            <p class="card-text">{{ number_format($biscuit->prix, 2) }} $</p>
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
