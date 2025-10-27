@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/biscuits.css') }}">

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
    <a href="{{ route('saveurs.index') }}">Saveurs</a>
    <a href="{{ route('about') }}">À propos</a>
  </div>
</div>

<div class="container py-5">
  <div class="row">
    <div class="col-md-6">
      @if($biscuit->image)
        <img src="{{ asset('Contenu/img/' . $biscuit->image) }}" 
             alt="{{ $biscuit->nom_biscuit }}" 
             class="img-fluid rounded-3 shadow-sm">
      @else
        <div class="no-image-placeholder rounded-3 d-flex align-items-center justify-content-center" 
             style="height:400px; background:#ffeaf2;">
          <span class="display-1">🍪</span>
        </div>
      @endif
    </div>

    <div class="col-md-6">
      <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
          <li class="breadcrumb-item"><a href="{{ route('biscuits.index') }}">Biscuits</a></li>
          <li class="breadcrumb-item active">{{ $biscuit->nom_biscuit }}</li>
        </ol>
      </nav>

      <h1 class="display-4 mb-3">{{ $biscuit->nom_biscuit }}</h1>

      <div class="saveur-chip mb-4">
        <span class="emoji">{{ $emojiMap[strtolower($biscuit->nom_saveur)] ?? '🍪' }}</span>
        {{ $biscuit->nom_saveur }}
      </div>

      <p class="lead mb-4">{{ $biscuit->description }}</p>

      <div class="price-tag mb-4">
        <span class="display-5 fw-bold text-primary">{{ number_format($biscuit->prix, 2) }} $</span>
      </div>

      <div class="d-grid gap-2">
        <a href="{{ route('commandes.create') }}" class="btn btn-primary btn-lg">
          Commander
        </a>
        <a href="{{ route('biscuits.index') }}" class="btn btn-outline-secondary">
          Retour aux biscuits
        </a>
      </div>
    </div>
  </div>
</div>

<footer class="mt-5">
  <small>© {{ date('Y') }} Snackin — Fait avec Laravel & beaucoup d'amour.</small>
</footer>
@endsection