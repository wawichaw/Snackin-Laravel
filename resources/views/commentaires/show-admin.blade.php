@extends('layouts.base')
@section('title', __('Détail du commentaire - Snackin'))

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/commentaires.css') }}">

<div class="snk-nav">
  <div class="snk-container">
    <a class="snk-logo" href="{{ route('home') }}">
      <img src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="{{ __('Snackin logo') }}" style="width:36px;height:36px;object-fit:contain">
      <strong>{{ __("Snackin'") }}</strong>
    </a>
    <span class="snk-badge">{{ __('Fait à Montréal') }}</span>

    <div class="snk-spacer"></div>
    <a href="{{ route('home') }}">{{ __('Accueil') }}</a>
    <a href="{{ route('biscuits.index') }}">{{ __('Biscuits') }}</a>
    <a href="{{ route('commandes.index') }}">{{ __('Gestion de commandes') }}</a>
    <a href="{{ route('saveurs.index') }}">{{ __('Saveurs') }}</a>
    <a href="{{ route('commentaires.admin') }}">{{ __('Gestion commentaires') }}</a>
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

<div class="commentaires-page">
  <div class="commentaires-content">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
      <div class="comment-form-cute">
        <h2 style="color: #2a1620; margin-bottom: 25px; font-size: 28px; font-weight: 800;">📄 Détail du Commentaire</h2>
        
        <div class="comment-card-cute" style="margin-bottom: 0;">
          <div class="comment-header-cute">
            <div class="comment-author-cute">
              <div class="author-avatar-cute">
                {{ strtoupper(substr($commentaire->nom_affiche, 0, 1)) }}
              </div>
              <div class="author-info-cute">
                <h3>{{ $commentaire->nom_affiche }}</h3>
                <p>
                  @if($commentaire->utilisateur_id)
                    Utilisateur connecté
                  @else
                    Visiteur ({{ $commentaire->email_visiteur ?? 'Email non fourni' }})
                  @endif
                </p>
              </div>
            </div>
            @if($commentaire->note)
              <div class="comment-rating-cute">
                @for($i = 1; $i <= 5; $i++)
                  @if($i <= $commentaire->note)
                    ⭐
                  @else
                    ☆
                  @endif
                @endfor
              </div>
            @endif
          </div>
          
          <p class="comment-content-cute">{{ $commentaire->texte }}</p>
          
          <div class="comment-meta-cute">
            <span class="comment-date-cute">{{ $commentaire->created_at->format('d/m/Y à H:i') }}</span>
            <span class="comment-biscuit-cute">🍪 {{ $commentaire->biscuit->nom_biscuit }}</span>
          </div>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 15px;">
          <h4 style="color: #2a1620; margin-bottom: 15px;">📊 Informations Admin</h4>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
            <div>
              <strong>ID :</strong> {{ $commentaire->id }}
            </div>
            <div>
              <strong>Statut :</strong> 
              <span class="status-badge-cute {{ $commentaire->modere ? 'status-approved-cute' : 'status-pending-cute' }}">
                {{ $commentaire->modere ? 'Approuvé' : 'En attente' }}
              </span>
            </div>
            <div>
              <strong>Biscuit ID :</strong> {{ $commentaire->biscuit_id }}
            </div>
            <div>
              <strong>Note :</strong> {{ $commentaire->note ?? 'Aucune' }}
            </div>
            @if($commentaire->utilisateur_id)
              <div>
                <strong>Utilisateur ID :</strong> {{ $commentaire->utilisateur_id }}
              </div>
            @endif
            <div>
              <strong>Dernière modification :</strong> {{ $commentaire->updated_at->format('d/m/Y à H:i') }}
            </div>
          </div>
        </div>

        <div class="page-actions">
          <a href="{{ route('commentaires.edit-admin', $commentaire) }}" class="btn-saveur btn-saveur-primary">
            ✏️ Modifier
          </a>
          <a href="{{ route('commentaires.admin') }}" class="btn-saveur btn-saveur-secondary">
            ↩️ Retour à la liste
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
