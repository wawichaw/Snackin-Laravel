@extends('layouts.base')
@section('title', __('Nouvelle saveur - Snackin'))

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/saveurs.css') }}">

<div class="snk-nav">
  <div class="snk-container">
    <a class="snk-logo" href="{{ route('home') }}">
      <img src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="{{ __('Snackin logo') }}" style="width:36px;height:36px;object-fit:contain">
      <strong>{{ __('Snackin\'') }}</strong>
    </a>
    <span class="snk-badge">{{ __('Fait à Montréal') }}</span>

    <div class="snk-spacer"></div>
    <a href="{{ route('home') }}">{{ __('Accueil') }}</a>
    <a href="{{ route('biscuits.index') }}">{{ __('Biscuits') }}</a>
    <a href="{{ route('commandes.index') }}">{{ __('Gestion de commandes') }}</a>
    <a href="{{ route('saveurs.index') }}">{{ __('Saveurs') }}</a>
    <a href="{{ route('about') }}">{{ __('À propos') }}</a>

    <div class="snk-spacer"></div>
    @auth
      <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">{{ __('Bonjour Admin,') }} {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="margin-left: 10px;">{{ __('Se déconnecter') }}</a>
      </form>
    @endauth
  </div>
</div>

<div class="saveurs-page">
  <div class="saveurs-content">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
      <div class="saveur-header">
        <h1 class="saveur-title">✨ {{ __('Nouvelle Saveur') }}</h1>
        <p class="saveur-subtitle">{{ __('Créez une nouvelle saveur pour enrichir votre collection de biscuits') }}</p>
      </div>

      @if($errors->any())
        <div class="alert-saveur alert-saveur-danger">
          <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="saveur-form-container">
        <form action="{{ route('saveurs.store') }}" method="post">
          @csrf
          
          <div class="form-group-saveur">
            <label for="nom_saveur">🍪 {{ __('Nom de la saveur') }} *</label>
            <input type="text" id="nom_saveur" name="nom_saveur" value="{{ old('nom_saveur') }}" required placeholder="{{ __('Ex: Chocolat, Vanille, Pistache...') }}">
          </div>

          <div class="form-group-saveur">
            <label for="emoji">😊 {{ __('Emoji') }}</label>
            <input type="text" id="emoji" name="emoji" value="{{ old('emoji') }}" placeholder="{{ __('Ex: 🍫, 🍓, 🥜...') }}">
            <small style="color: var(--saveur-muted); font-size: 14px;">{{ __('Ajoutez un emoji pour rendre la saveur plus attractive') }}</small>
          </div>

          <div class="form-group-saveur">
            <label for="description">📝 {{ __('Description') }}</label>
            <textarea id="description" name="description" placeholder="{{ __('Décrivez cette saveur, ses caractéristiques, son goût...') }}">{{ old('description') }}</textarea>
          </div>

          <div class="page-actions">
            <button type="submit" class="btn-saveur btn-saveur-primary">
              ✨ {{ __('Créer la saveur') }}
            </button>
            <a href="{{ route('saveurs.index') }}" class="btn-saveur btn-saveur-secondary">
              ↩️ {{ __('Annuler') }}
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
