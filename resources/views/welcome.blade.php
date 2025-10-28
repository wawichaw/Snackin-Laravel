<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Snackin — Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
</head>

<body>

    <img class="sprinkle" style="left:6%; top:8%; width:70px; transform:rotate(-12deg)"
        src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="" aria-hidden="true">
    <img class="sprinkle" style="right:8%; top:16%; width:60px; transform:rotate(18deg)"
        src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="" aria-hidden="true">
    <img class="sprinkle" style="left:18%; top:30%; width:40px; transform:rotate(8deg)"
        src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="" aria-hidden="true">
    <img class="sprinkle" style="right:24%; top:6%; width:50px; transform:rotate(-6deg)"
        src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="" aria-hidden="true">
    <img class="sprinkle" style="left:4%; bottom:8%; width:48px; transform:rotate(4deg)"
        src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="" aria-hidden="true">
    <img class="sprinkle" style="right:6%; bottom:18%; width:36px; transform:rotate(-14deg)"
        src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="" aria-hidden="true">
    <img class="sprinkle" style="left:50%; top:4%; width:28px; transform:translateX(-50%) rotate(6deg)"
        src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="" aria-hidden="true">
    <img class="sprinkle" style="left:60%; bottom:6%; width:28px; transform:rotate(-8deg)"
        src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="" aria-hidden="true">
    <div class="snk-nav">
        <div class="snk-container">
            <a class="snk-logo" href="{{ route('home') }}">
                <img src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="Snackin logo">
                <strong>Snackin'</strong>
            </a>
            <span class="snk-badge">{{ __('Fait à Montréal') }}</span>
            <div class="snk-spacer"></div>
            <a href="{{ route('biscuits.index') }}">{{ __('Nos biscuits') }}</a>
            @auth
                @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
                    <a href="{{ route('commandes.index') }}">{{ __('Commandes (admin)') }}</a>
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
                    <a href="{{ route('commentaires.admin') }}">{{ __('Voir les commentaires') }}</a>
                @else
                    <a href="{{ route('commentaires.public') }}">{{ __('Voir les commentaires') }}</a>
                @endif
            @else
                <a href="{{ route('commentaires.public') }}">{{ __('Voir les commentaires') }}</a>
            @endauth
            <a href="{{ route('about') }}">{{ __('À propos') }}</a>
            
            
            {{-- Options d'authentification --}}
            <div class="snk-spacer"></div>
            @auth
                @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
                    <span style="color: #000; font-weight: bold; margin-right: 15px; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">{{ __('Bonjour, :name', ['name' => 'Admin ' . Auth::user()->name]) }}</span>
                @else
                    <span style="color: #000; font-weight: bold; margin-right: 15px; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">{{ __('Bonjour, :name', ['name' => Auth::user()->name]) }}</span>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="margin-left: 10px;">{{ __('Se déconnecter') }}</a>
                </form>
            @else
                <a href="{{ route('login') }}" style="margin-right: 10px;">{{ __('Se connecter') }}</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">{{ __('S\'inscrire') }}</a>
                @endif
            @endauth
        </div>
    </div>

    <section class="hero">
        <div class="hero-inner">
            <div>
                <div class="kickers">
                    <span>🍪 Frais du jour</span>
                    <span>🧁 Fait maison</span>
                    <span>🌸 Très cute</span>
                </div>
                <h1>{{ __('Croquants dehors, fondants dedans.') }}<br>{{ __('Les biscuits qui rendent tout le monde heureux.') }}</h1>
                <p>{{ __('Gérez vos biscuits, découvrez les saveurs et passez vos commandes en 2 clics.') }}</p>

                <div class="cta-row">
                    <a class="btn primary" href="{{ route('commandes.create') }}">{{ __('Commander') }}</a>
                    <a class="btn" href="{{ route('biscuits.index') }}">{{ __('Découvrez notre sélection') }}</a>
                    @auth
                        @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
                            <a class="btn outline" href="{{ route('saveurs.index') }}">{{ __('Saveurs') }}</a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hero-card">
                <div class="hero-visual">
                    <img src="{{ asset('Contenu/img/cookie-oreo.jpg') }}" alt="Cookie Oreo">
                </div>
                <span class="sticker">Best-seller ✨</span>
            </div>
        </div>
    </section>


    <div class="marquee" aria-label="Bannière de saveurs — défilement">
        <div class="snk-container marquee-track" id="marquee-track">
            <span class="marquee-item">CHOCOLAT</span><span class="dot">•</span>
            <span class="marquee-item">OREO</span><span class="dot">•</span>
            <span class="marquee-item">PISTACHE</span><span class="dot">•</span>
            <span class="marquee-item">RED VELVET</span><span class="dot">•</span>
            <span class="marquee-item">NOISETTE</span><span class="dot">•</span>
            <span class="marquee-item">FRAMBOISE</span><span class="dot">•</span> <!-- <- ajouté -->
        </div>
    </div>




    <section class="section">
        <div class="grid">
            <div class="card">
                <h3>Commander en douceur</h3>
                <p>Choisis la taille (4, 6, 12) et compose ta boîte. <br>Tu récupères au point de ramassage.</p>
                <p><a class="btn primary" href="{{ route('commandes.create') }}">Je commande</a></p>
            </div>
            <div class="card">
                <h3>Découvrir le menu</h3>
                <p>Toutes les recettes dispo + notes et commentaires des gens.</p>
                <p><a class="btn" href="{{ route('biscuits.index') }}">Voir les biscuits</a></p>
            </div>
            <div class="card">
                <h3>Partager son avis</h3>
                <p>Découvrez ce que pensent nos clients et partagez votre expérience.</p>
                <p><a class="btn outline" href="{{ route('commentaires.public') }}">{{ __('Voir les commentaires') }}</a></p>
            </div>
            @auth
                @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
                    <div class="card">
                        <h3>Saveurs du moment</h3>
                        <p>Ajoute/édite les saveurs (admin) ou inspire-toi pour ta commande.</p>
                        <p><a class="btn outline" href="{{ route('saveurs.index') }}">Saveurs</a></p>
                    </div>
                @endif
            @endauth
        </div>
    </section>

    <footer>
        <small>{{ __('© :year Snackin — Fait avec Laravel & beaucoup d\'amour.', ['year' => date('Y')]) }}</small>
    </footer>

    <script>
        (function () {
            const marquee = document.querySelector('.marquee');
            const track = document.getElementById('marquee-track');
            if (!marquee || !track) return;

            const original = track.innerHTML.trim();

            track.innerHTML = original + original;
            while (track.scrollWidth < marquee.offsetWidth * 2.2) {
                track.innerHTML += original;
            }
        })();
    </script>

    <!-- Sélecteur de langue en haut -->
    <div style="position: fixed; top: 10px; right: 20px; z-index: 1000;">
        @include('components.language-switcher')
    </div>
</body>

</html>