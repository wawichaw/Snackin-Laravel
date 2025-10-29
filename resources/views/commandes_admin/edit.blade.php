@extends('layouts.base')
@section('title', __('Éditer la commande - Snackin'))

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
  <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter') }}</a>
      </form>
    @endauth
  </div>
</div>

<div class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
  <h1 style="color: #2a1620; margin-bottom: 30px;">{{ __('Éditer la commande') }} #{{ $commande->id }}</h1>

  @if($errors->any())
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
      <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('commandes.update', $commande) }}" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 20px;">
  <label for="client_nom" style="display: block; margin-bottom: 8px; font-weight: bold; color: #2a1620;">{{ __('Nom du client') }}</label>
      <input type="text" id="client_nom" name="client_nom" value="{{ old('client_nom', $commande->client_nom) }}" 
             style="width: 100%; padding: 12px; border: 2px solid #dee2e6; border-radius: 8px; font-size: 16px;" required>
    </div>

    <div style="margin-bottom: 20px;">
  <label for="client_email" style="display: block; margin-bottom: 8px; font-weight: bold; color: #2a1620;">{{ __('Email du client') }}</label>
      <input type="email" id="client_email" name="client_email" value="{{ old('client_email', $commande->client_email) }}" 
             style="width: 100%; padding: 12px; border: 2px solid #dee2e6; border-radius: 8px; font-size: 16px;" required>
    </div>

    <div style="margin-bottom: 20px;">
  <label for="status" style="display: block; margin-bottom: 8px; font-weight: bold; color: #2a1620;">{{ __('Statut de la commande') }}</label>
      <select id="status" name="status" style="width: 100%; padding: 12px; border: 2px solid #dee2e6; border-radius: 8px; font-size: 16px;" required>
  <option value="en_attente" {{ old('status', $commande->status) == 'en_attente' ? 'selected' : '' }}>{{ __('En attente') }}</option>
  <option value="en_preparation" {{ old('status', $commande->status) == 'en_preparation' ? 'selected' : '' }}>{{ __('En préparation') }}</option>
  <option value="prete" {{ old('status', $commande->status) == 'prete' ? 'selected' : '' }}>{{ __('Prête') }}</option>
  <option value="livree" {{ old('status', $commande->status) == 'livree' ? 'selected' : '' }}>{{ __('Livrée') }}</option>
  <option value="annulee" {{ old('status', $commande->status) == 'annulee' ? 'selected' : '' }}>{{ __('Annulée') }}</option>
      </select>
    </div>

    <div style="margin-bottom: 30px;">
  <label for="total_prix" style="display: block; margin-bottom: 8px; font-weight: bold; color: #2a1620;">{{ __('Prix total (€)') }}</label>
      <input type="number" id="total_prix" name="total_prix" value="{{ old('total_prix', $commande->total_prix) }}" 
             step="0.01" min="0" style="width: 100%; padding: 12px; border: 2px solid #dee2e6; border-radius: 8px; font-size: 16px;">
    </div>

    <div style="display: flex; gap: 15px; justify-content: flex-end;">
      <a href="{{ route('commandes.index') }}" 
         style="background: #6c757d; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;">
        {{ __('Annuler') }}
      </a>
      <button type="submit" 
              style="background: #28a745; color: white; padding: 12px 24px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer;">
        {{ __('Mettre à jour') }}
      </button>
    </div>
  </form>
</div>
@endsection