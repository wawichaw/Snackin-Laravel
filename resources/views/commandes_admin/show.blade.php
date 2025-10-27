@extends('layouts.base')
@section('title', 'Commande #' . $commande->id . ' - Snackin')

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">

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
      <span class="snk-greeting" style="color: #000; font-weight: bold;">Bonjour Admin, {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Se déconnecter</a>
      </form>
    @endauth
  </div>
</div>

<div class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="color: #2a1620; margin: 0;">Commande #{{ $commande->id }}</h1>
    <div style="display: flex; gap: 10px;">
      <a href="{{ route('commandes.edit', $commande) }}" 
         style="background: #ffc107; color: #212529; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
        Éditer
      </a>
      <a href="{{ route('commandes.index') }}" 
         style="background: #6c757d; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
        Retour à la liste
      </a>
    </div>
  </div>

  <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
      <div>
        <h3 style="color: #2a1620; margin-bottom: 15px; border-bottom: 2px solid #f8f9fa; padding-bottom: 10px;">Informations client</h3>
        <p style="margin: 10px 0;"><strong>Nom:</strong> {{ $commande->client_nom }}</p>
        <p style="margin: 10px 0;"><strong>Email:</strong> {{ $commande->client_email }}</p>
      </div>
      
      <div>
        <h3 style="color: #2a1620; margin-bottom: 15px; border-bottom: 2px solid #f8f9fa; padding-bottom: 10px;">Détails de la commande</h3>
        <p style="margin: 10px 0;"><strong>Date:</strong> {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
        <p style="margin: 10px 0;"><strong>Statut:</strong> 
          @php
            $statusColors = [
              'en_attente' => '#ffc107',
              'en_preparation' => '#17a2b8',
              'prete' => '#28a745',
              'livree' => '#6c757d',
              'annulee' => '#dc3545'
            ];
            $statusLabels = [
              'en_attente' => 'En attente',
              'en_preparation' => 'En préparation',
              'prete' => 'Prête',
              'livree' => 'Livrée',
              'annulee' => 'Annulée'
            ];
            $color = $statusColors[$commande->status] ?? '#6c757d';
            $label = $statusLabels[$commande->status] ?? $commande->status;
          @endphp
          <span style="background: {{ $color }}; color: white; padding: 4px 12px; border-radius: 12px; font-size: 14px; font-weight: bold;">
            {{ $label }}
          </span>
        </p>
        @if($commande->total_prix)
          <p style="margin: 10px 0;"><strong>Prix total:</strong> {{ number_format($commande->total_prix, 2) }}€</p>
        @endif
      </div>
    </div>

    @php
      $details = json_decode($commande->details_json, true);
    @endphp
    
    @if($details)
      <div>
        <h3 style="color: #2a1620; margin-bottom: 15px; border-bottom: 2px solid #f8f9fa; padding-bottom: 10px;">Détails de la commande</h3>
        
        @if(isset($details['taille']))
          <p style="margin: 10px 0;"><strong>Taille de boîte:</strong> {{ $details['taille'] }}</p>
        @endif
        
        @if(isset($details['quantites']) && is_array($details['quantites']))
          <div style="margin: 15px 0;">
            <strong>Quantités commandées:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
              @foreach($details['quantites'] as $biscuitId => $quantite)
                @if($quantite > 0)
                  @php
                    $biscuit = \App\Models\Biscuit::find($biscuitId);
                  @endphp
                  @if($biscuit)
                    <li>{{ $biscuit->nom_biscuit }}: {{ $quantite }}</li>
                  @else
                    <li>Biscuit ID {{ $biscuitId }}: {{ $quantite }}</li>
                  @endif
                @endif
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    @endif

    <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #f8f9fa;">
      <h3 style="color: #2a1620; margin-bottom: 15px;">Actions</h3>
      <div style="display: flex; gap: 15px;">
        <a href="{{ route('commandes.edit', $commande) }}" 
           style="background: #ffc107; color: #212529; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;">
          Modifier la commande
        </a>
        <form method="POST" action="{{ route('commandes.destroy', $commande) }}" style="display: inline;" 
              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
          @csrf
          @method('DELETE')
          <button type="submit" 
                  style="background: #dc3545; color: white; padding: 12px 24px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer;">
            Supprimer la commande
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection