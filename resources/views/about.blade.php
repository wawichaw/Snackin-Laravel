@extends('layouts.base')
@section('title', 'À propos - Snackin')

@section('content')
{{-- mêmes feuilles que l’accueil pour styliser la nav --}}
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/about.css') }}">

{{-- NAV (identique aux autres pages) --}}
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
    @auth
      @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
        <a href="{{ route('commandes.index') }}">Gestion de commandes</a>
        <a href="{{ route('saveurs.index') }}">Saveurs</a>
      @else
        <a href="{{ route('commandes.create') }}">Commander</a>
      @endif
    @else
      <a href="{{ route('commandes.create') }}">Commander</a>
    @endauth
    <a href="{{ route('about') }}" aria-current="page">À propos</a>


    <div class="snk-spacer"></div>
    @auth
      @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
        <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">Bonjour Admin, {{ Auth::user()->name }}</span>
      @else
        <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">Bonjour, {{ Auth::user()->name }}</span>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="margin-left: 10px;">Se déconnecter</a>
      </form>
    @else
      <a href="{{ route('login') }}" style="margin-right:10px;">Se connecter</a>
      @if (Route::has('register')) <a href="{{ route('register') }}">S’inscrire</a> @endif
    @endauth
  </div>
</div>

{{-- HERO --}}
<section class="about-hero">
  <div class="about-hero__art left">
    <img src="{{ asset('Contenu/img/cookie-smile.jpg') }}" alt="Cookie sourire Snackin">
  </div>

  <div class="about-hero__center">
    <span class="mini-badge">Fait à Montréal</span>
    <h1>À propos de <span>Snackin’</span></h1>
    <p class="subtitle">
      Des biscuits gourmands faits avec amour et une pincée de folie sucrée.
    </p>
  </div>

  <div class="about-hero__art right">
    <img src="{{ asset('Contenu/img/stack-cookies.png') }}" alt="Pile de cookies Snackin">
  </div>
</section>

{{-- NOS VALEURS --}}
<section class="about-section about-values container">
  <h2>Nos valeurs</h2>
  <div class="cards">
    <article class="card">
      <div class="ic">✨</div>
      <h3>Qualité</h3>
      <p>Des ingrédients choisis avec soin, des recettes testées & retestées — pour un goût toujours <strong>wow</strong>.</p>
    </article>
    <article class="card">
      <div class="ic">🤝</div>
      <h3>Partage</h3>
      <p>Un biscuit c’est meilleur à plusieurs. On crée des boîtes pensées pour toutes les petites fêtes.</p>
    </article>
    <article class="card">
      <div class="ic">💗</div>
      <h3>Famille</h3>
      <p>Une aventure artisanale, proche des gens, avec le sourire et le cœur sur la main.</p>
    </article>
  </div>
</section>

{{-- INFOS PROJET --}}
<section class="about-section about-project container">
  <div class="project-info-box">
    <h2>📚 Informations du Projet</h2>
    
    <div class="project-details">
      <div class="detail-item">
        <strong>Cours:</strong> 420-5H6 MO Applications Web transactionnelles
      </div>
      <div class="detail-item">
        <strong>Période:</strong> Automne 2025
      </div>
      <div class="detail-item">
        <strong>Institution:</strong> Collège Montmorency
      </div>
    </div>

    <div class="project-section">
      <h3>🔍 Étapes d'utilisation de l'application</h3>
      <ol class="usage-steps">
        <li><strong>Authentification:</strong> Connectez-vous avec les identifiants (email: <code>admin@snackin.com</code>, mdp: <code>password</code>) ou créez un compte.</li>
        <li><strong>Parcourir les biscuits:</strong> Consultez le catalogue dans la section "Biscuits" avec filtres par saveur et recherche.</li>
        <li><strong>Passer une commande:</strong> Cliquez sur "Commander" et remplissez le formulaire (choix de taille, sélection des biscuits).</li>
        <li><strong>Gestion (Admin):</strong> Les administrateurs peuvent gérer les commandes, les saveurs, et modérer les commentaires.</li>
        <li><strong>Commentaires:</strong> Laissez des avis sur les produits (visibles après modération admin).</li>
      </ol>
      <p class="note"><em>Résultats attendus:</em> L'application permet la navigation, l'authentification, la commande de produits, et la gestion administrative complète. Toutes les fonctionnalités CRUD sont opérationnelles.</p>
    </div>

    <div class="project-section">
      <h3>🗄️ Diagramme de la base de données</h3>
      <div class="diagram-container">
        <img src="{{ asset('Contenu/img/diagram_bd.PNG') }}" alt="Diagramme de la base de données" style="max-width: 100%; border-radius: 8px;">
      </div>
      <p class="diagram-note">Structure actuelle de la base de données avec les relations entre les tables (Users, Saveurs, Biscuits, Commandes, Commentaires, Ligne_Commandes).</p>
    </div>

    <div class="project-section">
      <h3>🔗 Inspirations</h3>
      <ul class="inspirations-list">
        <li>
          <a href="https://www.instagram.com/snackin.mtl/" target="_blank">Page instagram de Snackin'</a> - Inspiration pour le design 
        </li>
        <li>
          <a href="https://www.homersmtl.ca/fr" target="_blank">Homer's Montreal</a> - Référence pour l'interface e-commerce
        </li>
        <li>
          <a href="https://laravel.com/docs" target="_blank">Documentation Laravel</a> - Framework utilisé
        </li>
      </ul>
    </div>
  </div>
</section>

{{-- ÉQUIPE --}}
<section class="about-section about-team container">
  <h2>Notre équipe</h2>
  <div class="team-centered">
    <div class="teammate">
      <div class="avatar">G</div>
      <h3>Goufran</h3>
    </div>
    <div class="teammate">
      <div class="avatar">A</div>
      <h3>Aichatou</h3>
    </div>
    <div class="teammate">
      <div class="avatar">D</div>
      <h3>Destinee</h3>
    </div>
  </div>
</section>

{{-- CONTACT --}}
<section class="about-section about-contact container">
  <h2>Contact</h2>
  <div class="contact-card">
    <p>Une idée de saveur, une commande spéciale ou un événement ?</p>
    <a class="btn" href="{{ route('commandes.create') }}">Commander une boîte</a>
  </div>
</section>
@endsection
