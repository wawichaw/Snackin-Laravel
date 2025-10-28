<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-danger" href="{{ url('/') }}">
            Snackin
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Liens à gauche -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('biscuits.index') }}">Biscuits</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Commander</a></li>
                <li class="nav-item"><a class="nav-link" href="#">À propos</a></li>
            </ul>

            <!-- Liens à droite -->
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">S’inscrire</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Se déconnecter
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <li class="nav-item dropdown">
                    <a id="langDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       {{ strtoupper(session('locale', config('app.locale'))) }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                        <a class="dropdown-item {{ session('locale') == 'fr' ? 'active' : '' }}" href="{{ route('lang.switch', ['locale' => 'fr']) }}">FR</a>
                        <a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', ['locale' => 'en']) }}">EN</a>
                        <a class="dropdown-item {{ session('locale') == 'es' ? 'active' : '' }}" href="{{ route('lang.switch', ['locale' => 'es']) }}">ES</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
