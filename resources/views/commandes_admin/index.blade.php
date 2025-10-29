@extends('layouts.base')
@section('title', __('Gestion des commandes - Snackin'))

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">

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
  <a href="{{ route('about') }}">{{ __('À propos') }}</a>

    <div class="snk-spacer"></div>
    @auth
  <span class="snk-greeting" style="color: #000; font-weight: bold;">{{ __('Bonjour Admin,') }} {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Se déconnecter</a>
      </form>
    @endauth
  </div>
</div>

<div class="container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
  <h1 style="color: #2a1620; margin-bottom: 30px;">{{ __('Gestion des commandes') }}</h1>

  @if(session('success'))
    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
      {{ session('success') }}
    </div>
  @endif

  <div class="table-responsive">
    <table class="table" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
      <thead style="background: #f8f9fa;">
        <tr>
          <th style="padding: 15px; border-bottom: 2px solid #dee2e6;">{{ __('#') }}</th>
          <th style="padding: 15px; border-bottom: 2px solid #dee2e6;">{{ __('Client') }}</th>
          <th style="padding: 15px; border-bottom: 2px solid #dee2e6;">{{ __('Email') }}</th>
          <th style="padding: 15px; border-bottom: 2px solid #dee2e6;">{{ __('Détails') }}</th>
          <th style="padding: 15px; border-bottom: 2px solid #dee2e6;">{{ __('Total') }}</th>
          <th style="padding: 15px; border-bottom: 2px solid #dee2e6;">{{ __('Statut') }}</th>
          <th style="padding: 15px; border-bottom: 2px solid #dee2e6;">{{ __('Date') }}</th>
          <th style="padding: 15px; border-bottom: 2px solid #dee2e6;">{{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @forelse($commandes as $commande)
          <tr>
            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">{{ $commande->id }}</td>
            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">{{ $commande->client_nom }}</td>
            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">{{ $commande->client_email }}</td>
            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">
              @php
                $details = json_decode($commande->details_json, true);
              @endphp
              @if($details && isset($details['taille']))
                {{ __('Boîte') }} {{ $details['taille'] }}
              @else
                -
              @endif
            </td>
            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">
              @if($commande->total_prix)
                {{ number_format($commande->total_prix, 2) }}€
              @else
                -
              @endif
            </td>
            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">
                @php
                $statusColors = [
                  'en_attente' => '#ffc107',
                  'en_preparation' => '#17a2b8',
                  'prete' => '#28a745',
                  'livree' => '#6c757d',
                  'annulee' => '#dc3545'
                ];
                $statusLabels = [
                  'en_attente' => __('En attente'),
                  'en_preparation' => __('En préparation'),
                  'prete' => __('Prête'),
                  'livree' => __('Livrée'),
                  'annulee' => __('Annulée')
                ];
                $color = $statusColors[$commande->status] ?? '#6c757d';
                $label = $statusLabels[$commande->status] ?? $commande->status;
              @endphp
              <span style="background: {{ $color }}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                {{ $label }}
              </span>
            </td>
            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">
              {{ $commande->created_at->format('d/m/Y H:i') }}
            </td>
            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">
              <div style="display: flex; gap: 8px;">
                <a href="{{ route('commandes.show', $commande) }}" 
                   style="background: #17a2b8; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px;">
                  {{ __('Voir') }}
                </a>
                <a href="{{ route('commandes.edit', $commande) }}" 
                   style="background: #ffc107; color: #212529; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px;">
                  {{ __('Éditer') }}
                </a>
                <form method="POST" action="{{ route('commandes.destroy', $commande) }}" style="display: inline;" 
                      onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette commande ?') }}')">
                  @csrf
                  @method('DELETE')
        <button type="submit" 
          style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 6px; border: none; font-size: 12px; cursor: pointer;">
        {{ __('Supprimer') }}
      </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="padding: 40px; text-align: center; color: #6c757d;">
              {{ __('Aucune commande trouvée.') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
