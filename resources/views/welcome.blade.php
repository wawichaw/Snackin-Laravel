<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <title>Snackin – Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; margin:0; }
        header { padding: 24px; background:#fafafa; border-bottom:1px solid #eee; }
        nav { display:flex; gap:12px; align-items:center; padding:12px 24px; border-bottom:1px solid #eee; }
        nav a { text-decoration:none; color:#2563eb; font-weight:600; }
        .content { padding:24px; text-align:center; }
        .btn { display:inline-block; padding:10px 16px; border-radius:8px; border:1px solid #ddd; background:#fff; }
        .btn.primary { background:#2563eb; color:#fff; border-color:#2563eb; }
        .links { margin-top:16px; display:flex; gap:8px; justify-content:center; flex-wrap:wrap; }
        footer { margin-top:40px; padding:16px; text-align:center; color:#666; border-top:1px solid #eee; }
    </style>
</head>
<body>
<header>
    <h1>🍪 Snackin</h1>
    <p>Bienvenue sur l’application de gestion et commande de biscuits.</p>
</header>

<nav>
    <a href="{{ route('home') }}">Accueil</a>
    <a href="{{ route('biscuits.index') }}">Biscuits</a>
    <a href="{{ route('commandes.create') }}">Commandes</a>
    <a href="{{ route('saveurs.index') }}">Saveurs</a>
    {{-- Pas de route globale commentaires pour l’instant, on passe par chaque biscuit --}}
    <a href="{{ route('biscuits.index') }}">Commentaires</a>
    <a href="{{ route('about') }}">À propos</a>
</nav>

<div class="content">
    <h2>Découvrez nos biscuits faits avec amour 💛</h2>
    <p>Sur Snackin, vous pouvez :</p>
    <ul style="text-align:left; display:inline-block; margin:0 auto;">
        <li>Voir et gérer les <strong>biscuits</strong> (CRUD complet) ;</li>
        <li>Ajouter des <strong>commentaires</strong> sur chaque biscuit ;</li>
        <li>Gérer les <strong>saveurs</strong> ;</li>
        <li>Passer des <strong>commandes</strong> en ligne.</li>
    </ul>

    <div class="links">
        <a class="btn primary" href="{{ route('biscuits.index') }}">Parcourir les biscuits</a>
        <a class="btn" href="{{ route('commandes.create') }}">Commander maintenant</a>
        <a class="btn" href="{{ route('saveurs.index') }}">Gérer les saveurs</a>
    </div>
</div>

<footer>
    <small>© {{ date('Y') }} Snackin — Projet Laravel (CLÉE)</small>
</footer>
</body>
</html>
