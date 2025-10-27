@extends('layouts.base')
@section('title', 'Saveurs - Snackin')

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
    <a href="{{ route('saveurs.index') }}" aria-current="page">Saveurs</a>
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
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
      <div class="saveur-header">
        <h1 class="saveur-title">🍪 Nos Saveurs</h1>
        <p class="saveur-subtitle">Découvrez et gérez toutes les saveurs disponibles pour créer des biscuits exceptionnels</p>
      </div>

      @if(session('success'))
        <div class="alert-saveur alert-saveur-success">
          ✨ {{ session('success') }}
        </div>
      @endif

      <div style="text-align: center; margin-bottom: 40px;">
        <a href="{{ route('saveurs.create') }}" class="btn-saveur btn-saveur-primary">
          ✨ Ajouter une saveur
        </a>
      </div>

      @if($saveurs->count() > 0)
        <div class="saveurs-grid">
          @foreach($saveurs as $saveur)
            <div class="saveur-card">
              <span class="saveur-emoji">{{ $saveur->emoji ?? '🍪' }}</span>
              <h3 class="saveur-name">{{ $saveur->nom_saveur }}</h3>
              <p class="saveur-description">{{ $saveur->description ?? 'Aucune description disponible.' }}</p>
              <div class="saveur-actions">
                <a href="{{ route('saveurs.show', $saveur) }}" class="btn-saveur btn-saveur-secondary">
                  👁️ Voir
                </a>
                <a href="{{ route('saveurs.edit', $saveur) }}" class="btn-saveur btn-saveur-secondary">
                  ✏️ Modifier
                </a>
                <form action="{{ route('saveurs.destroy', $saveur) }}" method="post" style="display: inline;">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-saveur btn-saveur-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette saveur ?')">
                    🗑️ Supprimer
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div style="text-align: center; padding: 60px 20px;">
          <div style="font-size: 64px; margin-bottom: 20px;">🍪</div>
          <h3 style="color: var(--saveur-text); margin-bottom: 15px;">Aucune saveur pour le moment</h3>
          <p style="color: var(--saveur-muted); margin-bottom: 30px;">Commencez par ajouter votre première saveur !</p>
          <a href="{{ route('saveurs.create') }}" class="btn-saveur btn-saveur-primary">
            ✨ Créer la première saveur
          </a>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
