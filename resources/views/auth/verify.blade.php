@extends('layouts.base')

@section('title', __('Vérification Email'))

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
    <a href="{{ route('commandes.create') }}">{{ __('Commander') }}</a>
    <a href="{{ route('commentaires.public') }}">{{ __('Commentaires') }}</a>
    <a href="{{ route('about') }}">{{ __('À propos') }}</a>

    <div class="snk-spacer"></div>
    @auth
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Se déconnecter') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        <a href="{{ route('login') }}">{{ __('Se connecter') }}</a>
        <a href="{{ route('register') }}">{{ __("S'inscrire") }}</a>
    @endauth
  </div>
</div>

<div style="background: linear-gradient(135deg, #fff1f7 0%, #ffe6ee 100%); min-height: calc(100vh - 80px); padding: 40px 0;">
  <div style="max-width: 600px; margin: 0 auto; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 8px 32px rgba(236, 72, 153, 0.15); border: 2px solid #f7c6de;">
    <div style="text-align: center; margin-bottom: 30px;">
      <h2 style="color: #2a1620; font-size: 32px; font-weight: 800; margin-bottom: 10px;">📧 {{ __('Vérifiez votre adresse email') }}</h2>
      <p style="color: #666; font-size: 16px;">{{ __('Bienvenue chez Snackin\' ! 🍪') }}</p>
    </div>

    @if (session('resent'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <strong>✅ {{ __('Succès !') }}</strong><br>
            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
        </div>
    @endif

    <div style="background: #fff9f5; padding: 25px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #ec4899;">
      <p style="color: #2a1620; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
        {{ __('Avant de continuer, veuillez vérifier votre email en cliquant sur le lien de vérification que nous vous avons envoyé.') }}
      </p>
      <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0;">
        {{ __('Si vous ne voyez pas l\'email dans votre boîte de réception, vérifiez également votre dossier de courrier indésirable (spam).') }}
      </p>
    </div>

    <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px; margin-bottom: 20px;">
      <p style="color: #666; font-size: 14px; margin: 0 0 15px 0;">
        {{ __('Vous n\'avez pas reçu l\'email ?') }}
      </p>
      <form method="POST" action="{{ route('verification.resend') }}" style="display: inline;">
        @csrf
        <button type="submit" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; padding: 12px 30px; border: none; border-radius: 25px; font-size: 15px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3); transition: all 0.3s ease;">
          {{ __('🔄 Renvoyer l\'email de vérification') }}
        </button>
      </form>
    </div>

    <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #f7c6de;">
      <a href="{{ route('home') }}" style="color: #ec4899; text-decoration: none; font-weight: 500;">
        ← {{ __('Retour à l\'accueil') }}
      </a>
    </div>
  </div>
</div>
@endsection
