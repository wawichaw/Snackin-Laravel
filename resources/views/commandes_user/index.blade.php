@extends('layouts.base')

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
    <a href="{{ route('commandes.create') }}">Commander</a>
    <a href="{{ route('commentaires.public') }}">Commentaires</a>
    <a href="{{ route('about') }}">À propos</a>

    <div class="snk-spacer"></div>
    @auth
      <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">Bonjour, {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="margin-left: 10px;">Se déconnecter</a>
      </form>
    @endauth
  </div>
</div>

<div class="commentaires-page">
  <div class="commentaires-content">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
      <div class="saveur-header">
        <h1 class="saveur-title">📦 Mes Commandes</h1>
        <p class="saveur-subtitle">Suivez le statut de vos commandes en temps réel</p>
      </div>

      @if($commandes->isEmpty())
        <div style="text-align: center; padding: 60px 20px; background: #f8f9fa; border-radius: 15px; margin-top: 30px;">
          <div style="font-size: 64px; margin-bottom: 20px;">🛍️</div>
          <h3 style="color: #2a1620; margin-bottom: 15px;">Aucune commande trouvée</h3>
          <p style="color: #6c757d; margin-bottom: 25px;">Vous n'avez pas encore passé de commande.</p>
          <a href="{{ route('commandes.create') }}" class="btn-saveur btn-saveur-primary">
            🍪 Passer ma première commande
          </a>
        </div>
      @else
        <div class="admin-comment-table">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr>
                <th style="width: 10%;">Commande #</th>
                <th style="width: 15%;">Date</th>
                <th style="width: 20%;">Détails</th>
                <th style="width: 12%;">Prix Total</th>
                <th style="width: 15%;">Statut</th>
                <th style="width: 28%;">Informations</th>
              </tr>
            </thead>
            <tbody>
              @foreach($commandes as $commande)
                <tr>
                  <td><strong>#{{ $commande->id }}</strong></td>
                  <td>{{ $commande->created_at->format('d/m/Y à H:i') }}</td>
                  <td>
                    @if($commande->details)
                      @php
                        $details = is_string($commande->details) ? json_decode($commande->details, true) : $commande->details;
                      @endphp
                      <div style="font-size: 0.9em;">
                        <strong>Taille:</strong> {{ $details['taille'] ?? 'Non spécifiée' }}<br>
                        @if(isset($details['biscuits']) && is_array($details['biscuits']))
                          <strong>Biscuits:</strong> {{ count($details['biscuits']) }} sélectionné(s)
                        @endif
                      </div>
                    @else
                      <span style="color: #6c757d;">Détails non disponibles</span>
                    @endif
                  </td>
                  <td>
                    @if($commande->total_prix)
                      <strong style="color: #28a745;">{{ number_format($commande->total_prix, 2) }} $</strong>
                    @else
                      <span style="color: #6c757d;">—</span>
                    @endif
                  </td>
                  <td>
                    @php
                      $statusClass = '';
                      $statusText = '';
                      switch($commande->status ?? 'en_attente') {
                        case 'en_attente':
                          $statusClass = 'status-pending-cute';
                          $statusText = '⏳ En attente';
                          break;
                        case 'en_preparation':
                          $statusClass = 'status-in-progress-cute';
                          $statusText = '👨‍🍳 En préparation';
                          break;
                        case 'prete':
                          $statusClass = 'status-ready-cute';
                          $statusText = '✅ Prête';
                          break;
                        case 'livree':
                          $statusClass = 'status-delivered-cute';
                          $statusText = '🚚 Livrée';
                          break;
                        case 'annulee':
                          $statusClass = 'status-cancelled-cute';
                          $statusText = '❌ Annulée';
                          break;
                        default:
                          $statusClass = 'status-pending-cute';
                          $statusText = '⏳ En attente';
                      }
                    @endphp
                    <span class="status-badge-cute {{ $statusClass }}">
                      {{ $statusText }}
                    </span>
                  </td>
                  <td>
                    <div style="font-size: 0.85em; color: #6c757d;">
                      <strong>Client:</strong> {{ $commande->client_nom ?? $commande->nom_client ?? 'Non spécifié' }}<br>
                      <strong>Email:</strong> {{ $commande->client_email ?? $commande->email_client ?? 'Non spécifié' }}<br>
                      <strong>Commande:</strong> {{ $commande->created_at->diffForHumans() }}
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>

<style>
.status-pending-cute {
  background: #fff3cd;
  color: #856404;
  border: 1px solid #ffeaa7;
}

.status-in-progress-cute {
  background: #d1ecf1;
  color: #0c5460;
  border: 1px solid #bee5eb;
}

.status-ready-cute {
  background: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.status-delivered-cute {
  background: #e2e3e5;
  color: #383d41;
  border: 1px solid #d6d8db;
}

.status-cancelled-cute {
  background: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}
</style>
@endsection