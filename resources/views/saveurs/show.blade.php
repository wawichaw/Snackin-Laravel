@extends('layouts.base')
@section('title', $saveur->nom_saveur . ' - ' . __('Snackin'))

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
      <div class="saveur-detail">
        <span class="saveur-detail-emoji">{{ $saveur->emoji ?? '🍪' }}</span>
        <h1 class="saveur-detail-name">{{ $saveur->nom_saveur }}</h1>
        <p class="saveur-detail-description">
          {{ $saveur->description ?? __('Aucune description disponible pour cette saveur.') }}
        </p>
        
        <div class="page-actions">
          <a href="{{ route('saveurs.edit', $saveur) }}" class="btn-saveur btn-saveur-primary">
            ✏️ {{ __('Modifier') }}
          </a>
          <a href="{{ route('saveurs.index') }}" class="btn-saveur btn-saveur-secondary">
            ↩️ {{ __('Retour à la liste') }}
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
