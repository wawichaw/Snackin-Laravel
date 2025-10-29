<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-danger" href="{{ url('/') }}">
            {{ __('Snackin') }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Liens à gauche -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('biscuits.index') }}">{{ __('Biscuits') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#">{{ __('Commander') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#">{{ __('À propos') }}</a></li>
            </ul>

            <!-- Liens à droite -->
            <ul class="navbar-nav ms-auto">
                                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Se connecter') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('S\'inscrire') }}</a>
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
                                {{ __('Se déconnecter') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <li class="nav-item dropdown">
                    <a id="langDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none;">
                       @php 
                           $currentLocale = session('locale', config('app.locale')); 
                           $languages = [
                               'fr' => ['flag' => '🇫🇷', 'name' => 'Français'], 
                               'en' => ['flag' => '🇺🇸', 'name' => 'English'], 
                               'es' => ['flag' => '🇪🇸', 'name' => 'Español']
                           ];
                       @endphp
                       <span style="font-size: 1.2em; margin-right: 5px;">{{ $languages[$currentLocale]['flag'] ?? '🇫🇷' }}</span>
                       <span class="d-none d-md-inline">{{ $languages[$currentLocale]['name'] ?? 'Français' }}</span>
                       <span class="d-md-none">{{ strtoupper($currentLocale) }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="langDropdown" style="min-width: 160px;">
                        @foreach($languages as $code => $lang)
                            <a class="dropdown-item d-flex align-items-center {{ session('locale') == $code ? 'active bg-light' : '' }}" 
                               href="{{ route('lang.switch', ['locale' => $code]) }}"
                               style="padding: 8px 16px; transition: all 0.2s;">
                                <span style="font-size: 1.1em; margin-right: 8px;">{{ $lang['flag'] }}</span>
                                <span>{{ $lang['name'] }}</span>
                                @if(session('locale') == $code)
                                    <span class="ms-auto text-primary">✓</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
