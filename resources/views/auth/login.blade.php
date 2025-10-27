@extends('layouts.base')

@section('title', 'Connexion')

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
    <a href="{{ route('commandes.create') }}">Commander</a>
    <a href="{{ route('commentaires.public') }}">Commentaires</a>
    <a href="{{ route('about') }}">À propos</a>

    <div class="snk-spacer"></div>
    <a href="{{ route('login') }}" aria-current="page">Se connecter</a>
    @if (Route::has('register')) 
      <a href="{{ route('register') }}">S'inscrire</a> 
    @endif
  </div>
</div>

<div style="background: linear-gradient(135deg, #fff1f7 0%, #ffe6ee 100%); min-height: calc(100vh - 80px); padding: 40px 0;">
  <div style="max-width: 500px; margin: 0 auto; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 8px 32px rgba(236, 72, 153, 0.15); border: 2px solid #f7c6de;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #2a1620; font-size: 28px; font-weight: 800;">🔐 Se connecter</h2>

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
            @error('email')
                <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Mot de passe</label>
            <input id="password" type="password" name="password" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
            @error('password')
                <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="checkbox" name="remember" id="remember" style="margin-right: 8px;">
                Se souvenir de moi
            </label>
        </div>

        <div style="text-align: center;">
            <button type="submit" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; padding: 15px 40px; border: none; border-radius: 25px; font-size: 16px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3); transition: all 0.3s ease;">
                ✨ Se connecter
            </button>
            
            @if (Route::has('password.request'))
                <div style="margin-top: 15px;">
                    <a href="{{ route('password.request') }}" style="color: #9b182b; text-decoration: none;">
                        Mot de passe oublié ?
                    </a>
                </div>
            @endif
            
            <div style="margin-top: 20px;">
                <a href="{{ route('register') }}" style="color: #9b182b; text-decoration: none;">
                    Pas encore de compte ? S'inscrire
                </a>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection
