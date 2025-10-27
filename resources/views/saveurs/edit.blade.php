@extends('layouts.base')
@section('title', 'Modifier la saveur - Snackin')

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/saveurs.css') }}">

<div class="snk-nav">
  <div class="snk-container">
    <a class="snk-logo" href="{{ route('home') }}">
      <img src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="Snackin logo" style="width:36px;height:36px;object-fit:contain">
      <strong>Snackin'</strong>
    </a>
    <span class="snk-badge">Fait à Montréal</span>

    <div class="snk-spacer"></div>
    <a href="{{ route('home') }}">Accueil</a>
    <a href="{{ route('biscuits.index') }}">Biscuits</a>
    <a href="{{ route('commandes.index') }}">Gestion de commandes</a>
    <a href="{{ route('saveurs.index') }}">Saveurs</a>
    <a href="{{ route('about') }}">À propos</a>

    <div class="snk-spacer"></div>
    @auth
      <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">Bonjour Admin, {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="margin-left: 10px;">Se déconnecter</a>
      </form>
    @endauth
  </div>
</div>

<div class="saveurs-page">
  <div class="saveurs-content">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
      <div class="saveur-header">
        <h1 class="saveur-title">✏️ Modifier la Saveur</h1>
        <p class="saveur-subtitle">Modifiez les informations de cette saveur</p>
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
        <form action="{{ route('saveurs.update', $saveur) }}" method="post">
          @csrf @method('PUT')
          
          <div class="form-group-saveur">
            <label for="nom_saveur">🍪 Nom de la saveur *</label>
            <input type="text" id="nom_saveur" name="nom_saveur" value="{{ old('nom_saveur', $saveur->nom_saveur) }}" required placeholder="Ex: Chocolat, Vanille, Pistache...">
          </div>

          <div class="form-group-saveur">
            <label for="emoji">😊 Emoji</label>
            <input type="text" id="emoji" name="emoji" value="{{ old('emoji', $saveur->emoji) }}" placeholder="Ex: 🍫, 🍓, 🥜...">
            <small style="color: var(--saveur-muted); font-size: 14px;">Ajoutez un emoji pour rendre la saveur plus attractive</small>
          </div>

          <div class="form-group-saveur">
            <label for="description">📝 Description</label>
            <textarea id="description" name="description" placeholder="Décrivez cette saveur, ses caractéristiques, son goût...">{{ old('description', $saveur->description) }}</textarea>
          </div>

          <div class="page-actions">
            <button type="submit" class="btn-saveur btn-saveur-primary">
              ✨ Mettre à jour
            </button>
            <a href="{{ route('saveurs.index') }}" class="btn-saveur btn-saveur-secondary">
              ↩️ Annuler
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
