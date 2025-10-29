@extends('layouts.base')
@section('title', __('Nouveau biscuit'))
@section('content')

<link rel="stylesheet" href="{{ asset('Contenu/css/biscuit-edit.css') }}">

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
    <a href="{{ route('commandes.create') }}">{{ __('Commander') }}</a>
    <a href="{{ route('saveurs.index') }}">{{ __('Saveurs') }}</a>
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

<h1 class="mb-3">{{ __('Nouveau biscuit') }}</h1>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<form action="{{ route('biscuits.store') }}"
      method="POST"
      class="card p-4 biscuit-edit-card"
      enctype="multipart/form-data">
  @csrf

  {{-- NOM --}}
  <div class="mb-3">
    <label class="form-label">{{ __('Nom') }}</label>
    <input type="text" name="nom_biscuit" class="form-control"
           value="{{ old('nom_biscuit') }}" required>
  </div>

  {{-- PRIX --}}
  <div class="mb-3">
    <label class="form-label">{{ __('Prix') }}</label>
    <input type="number" step="0.01" name="prix" class="form-control"
           value="{{ old('prix') }}" required>
  </div>

  {{-- DESCRIPTION --}}
  <div class="mb-3">
    <label class="form-label">{{ __('Description') }}</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
  </div>

  {{-- SAVEUR (liste déroulante) --}}
  <div class="mb-3">
    <label class="form-label">{{ __('Saveur') }}</label>
    <select name="saveur_id" class="form-control" required>
      <option value="" disabled {{ !old('saveur_id') ? 'selected' : '' }}>{{ __('Choisir une saveur…') }}</option>
      @foreach($saveurs as $saveur)
        <option value="{{ $saveur->id }}" {{ old('saveur_id') == $saveur->id ? 'selected' : '' }}>
          {{ ($saveur->emoji ?? '🍪') . ' ' . __(ucfirst($saveur->nom_saveur)) }}
        </option>
      @endforeach
    </select>
  </div>

  {{-- IMAGE (upload fichier) --}}
  <div class="mb-3">
    <label class="form-label">{{ __('Image') }}</label>
    <input type="file" name="image" class="form-control">
    <small class="text-muted">{{ __('Formats conseillés : JPG/PNG, ~1–2 Mo.') }}</small>
  </div>

  {{-- BOUTONS --}}
  <div class="d-flex gap-2 justify-content-center mt-3">
    <button class="btn btn-primary">{{ __('Enregistrer') }}</button>
    <a class="btn btn-outline-secondary" href="{{ route('biscuits.index') }}">{{ __('Annuler') }}</a>
  </div>
</form>

<footer>
  <small>{{ __('© :year Snackin — Fait avec Laravel & beaucoup d\'amour.', ['year' => date('Y')]) }}</small>
</footer>
@endsection
