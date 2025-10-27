@extends('layouts.base')
@section('title', 'Modifier le commentaire - Snackin')

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/commentaires.css') }}">

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
    <a href="{{ route('commentaires.admin') }}">Gestion commentaires</a>
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

<div class="commentaires-page">
  <div class="commentaires-content">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
      <div class="comment-form-cute">
        <h2 style="color: #2a1620; margin-bottom: 25px; font-size: 28px; font-weight: 800;">✏️ Modifier le Commentaire</h2>
        
        @if($errors->any())
          <div class="alert-saveur alert-saveur-danger">
            <ul style="margin: 0; padding-left: 20px;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('commentaires.update-admin', $commentaire) }}" method="post">
          @csrf
          @method('PUT')
          
          <div class="form-group-cute">
            <label for="biscuit_id">🍪 Biscuit</label>
            <select id="biscuit_id" name="biscuit_id" required>
              @foreach($biscuits as $biscuit)
                <option value="{{ $biscuit->id }}" {{ old('biscuit_id', $commentaire->biscuit_id) == $biscuit->id ? 'selected' : '' }}>
                  {{ $biscuit->nom_biscuit }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group-cute">
            <label for="texte">💭 Commentaire</label>
            <textarea id="texte" name="texte" rows="4" required placeholder="Modifiez le contenu du commentaire...">{{ old('texte', $commentaire->texte) }}</textarea>
          </div>

          <div class="form-group-cute">
            <label for="note">⭐ Note (1-5 étoiles)</label>
            <select id="note" name="note">
              <option value="">Choisissez une note</option>
              <option value="1" {{ old('note', $commentaire->note) == 1 ? 'selected' : '' }}>⭐ (1 étoile)</option>
              <option value="2" {{ old('note', $commentaire->note) == 2 ? 'selected' : '' }}>⭐⭐ (2 étoiles)</option>
              <option value="3" {{ old('note', $commentaire->note) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 étoiles)</option>
              <option value="4" {{ old('note', $commentaire->note) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 étoiles)</option>
              <option value="5" {{ old('note', $commentaire->note) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 étoiles)</option>
            </select>
          </div>

          @if(!$commentaire->utilisateur_id)
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
              <div class="form-group-cute">
                <label for="nom_visiteur">👤 Nom du visiteur</label>
                <input type="text" id="nom_visiteur" name="nom_visiteur" value="{{ old('nom_visiteur', $commentaire->nom_visiteur) }}">
              </div>
              <div class="form-group-cute">
                <label for="email_visiteur">📧 Email du visiteur</label>
                <input type="email" id="email_visiteur" name="email_visiteur" value="{{ old('email_visiteur', $commentaire->email_visiteur) }}">
              </div>
            </div>
          @endif

          <div class="form-group-cute">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
              <input type="checkbox" name="modere" value="1" {{ old('modere', $commentaire->modere) ? 'checked' : '' }}>
              <span>✅ Commentaire approuvé (visible publiquement)</span>
            </label>
          </div>

          <div class="page-actions">
            <button type="submit" class="btn-saveur btn-saveur-primary">
              ✨ Mettre à jour
            </button>
            <a href="{{ route('commentaires.show-admin', $commentaire) }}" class="btn-saveur btn-saveur-secondary">
              👁️ Voir le détail
            </a>
            <a href="{{ route('commentaires.admin') }}" class="btn-saveur btn-saveur-secondary">
              ↩️ Retour à la liste
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
