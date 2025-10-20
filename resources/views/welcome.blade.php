<!-- Affichage -->
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}" />
        <title>{{ $titre ?? 'Snackin' }}</title>
    </head>
    <body>
        <div id="global">
            <header>
                <a href="index.php"><h1 id="titreBlog">Snackin</h1></a>
                <p>Bienvenue dans notre site!</p>
                <div class="user-bar">
                    @if (session()->has('util_id'))
                        <span>
                            Bonjour, <strong>{{ session('prenom') }}</strong>
                        </span>
                        &nbsp;
                        <a href="{{ url('auth/logout') }}" class="btn btn-white">Se déconnecter</a>
                    @else
                        <a href="{{ url('auth/login') }}" class="btn btn-white">Se connecter</a>
            @endif
                </div>
            </header>
            <div id="contenu">
                {{ $contenu ?? '' }}
        </div>

            <nav class="navigation">
                <a href="{{ url('/') }}" class="btn btn-primary">Accueil</a>
                <a href="{{ url('biscuit') }}" class="btn btn-success">Biscuit</a>
                @if (session()->has('util_id') && session('identifiant') === 'admin')
                    <a href="{{ url('commandes') }}" class="btn btn-warning">Admin Commandes</a>
                @else
                    <a href="{{ url('commandes') }}" class="btn btn-warning">Commandes</a>
                @endif
                <a href="{{ url('about') }}" class="btn btn-secondary">À propos</a>
               
                @if (session()->has('util_id'))
                    <a href="{{ url('auth/logout') }}" class="btn btn-danger">Déconnexion</a>
                @else
                    <a href="{{ url('auth/login') }}" class="btn btn-outline">Connexion</a>
        @endif
            </nav>
            <footer id="piedSite">
                    Blog realiser avec PHP et Laravel.
            </footer>
            </div>
    </body>
</html>
