@extends('layouts.base')
@section('title', 'Modifier biscuit')
@section('content')

<link rel="stylesheet" href="{{ asset('Contenu/css/biscuit-edit.css') }}">

{{-- NAV / HEADER — identique à accueil/index --}}
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

<h1 class="mb-3">Modifier : {{ $biscuit->nom_biscuit }}</h1>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<form action="{{ route('biscuits.update', $biscuit) }}" method="POST" class="card p-4 biscuit-edit-card" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  {{-- NOM --}}
  <div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="nom_biscuit" class="form-control" value="{{ old('nom_biscuit', $biscuit->nom_biscuit) }}" required>
  </div>

  {{-- PRIX --}}
  <div class="mb-3">
    <label class="form-label">Prix</label>
    <input type="number" step="0.01" name="prix" class="form-control" value="{{ old('prix', $biscuit->prix) }}" required>
  </div>

  {{-- DESCRIPTION --}}
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $biscuit->description) }}</textarea>
  </div>

  {{-- SAVEUR (liste déroulante) --}}
  @php
    $saveurs = ['original','chocolat','caramel','vanille','smores','oreo'];
    $currentSaveur = old('saveur', $biscuit->saveur ?? '');
  @endphp
  <div class="mb-3">
    <label class="form-label">Saveur</label>
    <select name="saveur" class="form-control" required>
      <option value="" disabled {{ $currentSaveur==='' ? 'selected' : '' }}>Choisir une saveur…</option>
      @foreach($saveurs as $sv)
        <option value="{{ $sv }}" {{ $currentSaveur === $sv ? 'selected' : '' }}>
          {{ ucfirst($sv) }}
        </option>
      @endforeach
    </select>
    <small class="text-muted">Choix imposé — pas de saisie libre.</small>
  </div>

  {{-- IMAGE --}}
  <div class="mb-3">
    <label class="form-label">Nouvelle image</label>
    <input type="file" name="image" class="form-control">
    <small class="text-muted">Formats conseillés : JPG/PNG, ~1–2 Mo.</small>
  </div>

  {{-- BOUTONS --}}
  <div class="d-flex gap-2 justify-content-center mt-3">
    <button class="btn btn-primary">Mettre à jour</button>
    <a class="btn btn-outline-secondary" href="{{ route('biscuits.index') }}">Annuler</a>
  </div>
</form>

<footer>
  <small>© {{ date('Y') }} Snackin — Fait avec Laravel & beaucoup d’amour.</small>
</footer>
@endsection
