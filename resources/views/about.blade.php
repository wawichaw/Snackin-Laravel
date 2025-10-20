<!-- Affichage -->
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}" />
        <title>{{ $titre ?? 'À propos - Snackin' }}</title>
    </head>
    <body>
        <div id="global">
            <header>
                <a href="{{ url('/') }}"><h1 id="titreBlog">Snackin</h1></a>
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
                <h2>À propos de Snackin</h2>
                
                <p>Snackin est une entreprise familiale fondée par 3 sœurs passionnées de pâtisserie et du partage.</p>
                
                <h3>Notre histoire</h3>
                <p>Tout a commencé dans notre cuisine. Depuis son jeune âge, Sabrine nous faisait des recettes sorties de son imagination. Il y a eu des moments où ses recettes étaient incroyables et d'autres où nous peinions à finir le plat, mais aujourd'hui c'est la pâtissière de chez nous et sa réputation la précède. Nous avons cru en elle et nous voilà aujourd'hui avec notre entreprise.</p>
                
                <h3>Nos valeurs</h3>
                <ul>
                    <li><strong>Qualité :</strong> Nous utilisons uniquement des ingrédients frais et de qualité</li>
                    <li><strong>Partage :</strong> Nous croyons que les bons moments se partagent autour d'une pâtisserie</li>
                    <li><strong>Famille :</strong> Chaque création est faite avec amour et attention</li>
                </ul>
                
                <h3>Notre équipe</h3>
                <p>Les trois sœurs fondatrices travaillent ensemble pour vous offrir les meilleures pâtisseries. Chacune apporte sa spécialité :</p>
                <ul>
                    <li><strong>Sabrine :</strong> Notre chef pâtissière, elle excelle dans la création et la réalisation de tous nos délices</li>
                    <li><strong>Aicha :</strong> Responsable de la communication clientèle et de la gestion des événements</li>
                    <li><strong>Yousra :</strong> S'occupe de la gestion administrative et du bon fonctionnement de l'entreprise</li>
                </ul>
                
                <h3>Contact</h3>
                <p>N'hésitez pas à nous contacter pour toute question ou commande spéciale. Nous serons ravies de vous aider à créer des moments sucrés inoubliables !</p>
            </div>
            
            <nav class="navigation">
                <a href="{{ url('/') }}" class="btn btn-primary">Accueil</a>
                <a href="{{ url('menu') }}" class="btn btn-success">Menu</a>
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
                    Blog réalisé avec PHP et Laravel.
            </footer>
            </div>
    </body>
</html>
