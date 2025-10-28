@extends('layouts.base')
@section('title', 'Gestion des commentaires - Snackin')

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
    <a href="{{ route('commentaires.admin') }}" aria-current="page">Gestion commentaires</a>
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
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 40px 20px;">
      <div class="saveur-header">
        <h1 class="saveur-title">💬 Gestion des Commentaires</h1>
        <p class="saveur-subtitle">Modérez et gérez tous les commentaires de vos clients</p>
      </div>

      @if(session('success'))
        <div class="alert-saveur alert-saveur-success">
          ✨ {{ session('success') }}
        </div>
      @endif

      <div class="admin-comment-table">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th style="width: 5%;">#</th>
              <th style="width: 12%;">Auteur</th>
              <th style="width: 12%;">Biscuit</th>
              <th style="width: 22%;">Commentaire</th>
              <th style="width: 15%;">Note</th>
              <th style="width: 15%;">Statut</th>
              <th style="width: 10%;">Date</th>
              <th style="width: 9%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($commentaires as $commentaire)
              <tr>
                <td>{{ $commentaire->id }}</td>
                <td>
                  <strong>{{ $commentaire->nom_affiche }}</strong>
                  @if($commentaire->email_visiteur)
                    <br><small style="color: var(--comment-muted);">{{ $commentaire->email_visiteur }}</small>
                  @endif
                </td>
                <td>{{ $commentaire->biscuit->nom_biscuit }}</td>
                <td style="max-width: 300px;">
                  <div style="max-height: 60px; overflow: hidden;">
                    {{ Str::limit($commentaire->texte, 100) }}
                  </div>
                </td>
                <td>
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
                  @else
                    <span style="color: var(--comment-muted);">-</span>
                  @endif
                </td>
                <td>
                  <span class="status-badge-cute {{ $commentaire->modere ? 'status-approved-cute' : 'status-pending-cute' }}">
                    {{ $commentaire->modere ? 'Approuvé' : 'En attente' }}
                  </span>
                </td>
                <td>{{ $commentaire->created_at->format('d/m/Y H:i') }}</td>
                <td>
                  <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <a href="{{ route('commentaires.show-admin', $commentaire) }}" class="action-btn-cute btn-approve-cute">
                      📄 Voir
                    </a>
                    <a href="{{ route('commentaires.edit-admin', $commentaire) }}" class="action-btn-cute btn-approve-cute">
                      ✏️ Éditer
                    </a>
                    
                    @if($commentaire->modere)
                      <form method="POST" action="{{ route('commentaires.moderate', $commentaire) }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="action" value="reject">
                        <button type="submit" class="action-btn-cute btn-reject-cute">
                          ❌ Rejeter
                        </button>
                      </form>
                    @else
                      <form method="POST" action="{{ route('commentaires.moderate', $commentaire) }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="action" value="approve">
                        <button type="submit" class="action-btn-cute btn-approve-cute">
                          ✅ Approuver
                        </button>
                      </form>
                    @endif
                    
                    <form method="POST" action="{{ route('commentaires.destroy-admin', $commentaire) }}" style="display: inline;" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="action-btn-cute btn-delete-cute">
                        🗑️ Supprimer
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" style="padding: 40px; text-align: center; color: var(--comment-muted);">
                  <div style="font-size: 48px; margin-bottom: 20px;">💬</div>
                  <h3>Aucun commentaire trouvé</h3>
                  <p>Les commentaires de vos clients apparaîtront ici.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top: 30px; text-align: center;">
        {{ $commentaires->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
