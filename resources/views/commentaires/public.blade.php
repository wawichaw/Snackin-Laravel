@extends('layouts.base')
@section('title', __('Commentaires - Snackin'))

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/commentaires.css') }}">

<div class="commentaires-page">

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
    @auth
      @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
        <a href="{{ route('commandes.index') }}">{{ __('Gestion de commandes') }}</a>
        <a href="{{ route('saveurs.index') }}">{{ __('Saveurs') }}</a>
      @else
        <a href="{{ route('commandes.create') }}">{{ __('Commander') }}</a>
        <a href="{{ route('mes.commandes') }}">{{ __('Mes commandes') }}</a>
      @endif
    @else
      <a href="{{ route('commandes.create') }}">{{ __('Commander') }}</a>
    @endauth
    @auth
      @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
        <a href="{{ route('commentaires.admin') }}">{{ __('Gestion commentaires') }}</a>
      @else
        <a href="{{ route('commentaires.public') }}" aria-current="page">{{ __('Commentaires') }}</a>
      @endif
    @else
      <a href="{{ route('commentaires.public') }}" aria-current="page">{{ __('Commentaires') }}</a>
    @endauth
    <a href="{{ route('about') }}">{{ __('À propos') }}</a>


    <div class="snk-spacer"></div>
    @auth
      @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
        <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">{{ __('Bonjour Admin,') }} {{ Auth::user()->name }}</span>
      @else
        <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">{{ __('Bonjour,') }} {{ Auth::user()->name }}</span>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter') }}</a>
      </form>
    @else
      <a href="{{ route('login') }}" style="margin-right:10px;">{{ __('Se connecter') }}</a>
      @if (Route::has('register')) <a href="{{ route('register') }}">{{ __("S'inscrire") }}</a> @endif
    @endauth
  </div>
</div>

<div class="container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
  <h1 style="color: #2a1620; margin-bottom: 30px;">{{ __('Commentaires des clients') }}</h1>

  @if(session('success'))
    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
      <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Formulaire d'ajout de commentaire -->
  <div class="comment-form-cute">
    <h2 style="color: #2a1620; margin-bottom: 25px; font-size: 28px; font-weight: 800;"> {{ __('💬 Ajouter un commentaire') }}</h2>
    
    <form method="POST" action="{{ route('commentaires.store') }}">
      @csrf
      
      <div class="form-group-cute">
        <label for="biscuit_id">🍪 {{ __('Biscuit') }}</label>
        <select id="biscuit_id" name="biscuit_id" required>
          <option value="">{{ __('Choisissez un biscuit') }}</option>
          @foreach($biscuits as $biscuit)
            <option value="{{ $biscuit->id }}">{{ $biscuit->nom_biscuit }}</option>
          @endforeach
        </select>
      </div>

      @guest
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
          <div class="form-group-cute">
            <label for="nom_visiteur">👤 {{ __('Votre nom') }}</label>
            <input type="text" id="nom_visiteur" name="nom_visiteur" required>
          </div>
          <div class="form-group-cute">
            <label for="email_visiteur">📧 {{ __('Votre email') }}</label>
            <input type="email" id="email_visiteur" name="email_visiteur">
          </div>
        </div>
      @endguest

      <div class="form-group-cute">
        <label for="note">⭐ {{ __('Note (1-5 étoiles)') }}</label>
        <select id="note" name="note">
          <option value="">{{ __('Choisissez une note') }}</option>
          <option value="1">⭐ {{ __('(1 étoile)') }}</option>
          <option value="2">⭐⭐ {{ __('(2 étoiles)') }}</option>
          <option value="3">⭐⭐⭐ {{ __('(3 étoiles)') }}</option>
          <option value="4">⭐⭐⭐⭐ {{ __('(4 étoiles)') }}</option>
          <option value="5">⭐⭐⭐⭐⭐ {{ __('(5 étoiles)') }}</option>
        </select>
      </div>

      <div class="form-group-cute">
        <label for="texte">💭 {{ __('Votre commentaire') }}</label>
        <textarea id="texte" name="texte" rows="4" required placeholder="{{ __('Partagez votre expérience avec ce biscuit...') }}"></textarea>
      </div>

      <button type="submit" class="btn-cute">
         {{ __('✨ Publier le commentaire') }}
      </button>
    </form>
  </div>

  <!-- Liste des commentaires -->
  <div>
    <h2 style="color: #2a1620; margin-bottom: 20px;">{{ __('Commentaires récents') }}</h2>
    
    @forelse($commentaires as $commentaire)
      <div class="comment-card-cute">
        <div class="comment-header-cute">
          <div class="comment-author-cute">
            <div class="author-avatar-cute">
              {{ strtoupper(substr($commentaire->nom_affiche, 0, 1)) }}
            </div>
            <div class="author-info-cute">
              <h3>{{ $commentaire->nom_affiche }}</h3>
              <p>{{ __('sur') }} <strong>{{ $commentaire->biscuit->nom_biscuit }}</strong></p>
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
          <span class="comment-date-cute">{{ $commentaire->created_at->format('d/m/Y') }} {{ __('à') }} {{ $commentaire->created_at->format('H:i') }}</span>
          <span class="comment-biscuit-cute">🍪 {{ $commentaire->biscuit->nom_biscuit }}</span>
        </div>
      </div>
    @empty
      <div style="text-align: center; padding: 40px; color: #6c757d;">
        <p>{{ __('Aucun commentaire pour le moment. Soyez le premier à commenter !') }}</p>
      </div>
    @endforelse

    {{ $commentaires->links() }}
  </div>
</div>
@endsection
