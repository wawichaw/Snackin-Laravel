@php
    $currentLocale = session('locale', config('app.locale')); 
    $languages = [
        'fr' => ['flag' => '🇫🇷', 'name' => 'Français'], 
        'en' => ['flag' => '🇺🇸', 'name' => 'English'], 
        'es' => ['flag' => '🇪🇸', 'name' => 'Español']
    ];
@endphp

<div class="nav-language-switcher" style="position: relative; display: inline-block; margin-left: 20px;">
    <div class="current-lang" 
         style="display: flex; align-items: center; cursor: pointer; padding: 8px 15px; 
                background: rgba(255,255,255,0.9); border-radius: 20px; transition: all 0.3s ease; 
                border: 2px solid rgba(42,22,32,0.2); box-shadow: 0 2px 10px rgba(0,0,0,0.1);"
         onclick="toggleNavLanguageMenu()"
         onmouseover="this.style.background='rgba(255,255,255,1)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.15)'"
         onmouseout="this.style.background='rgba(255,255,255,0.9)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
        <span style="font-size: 1.2em; margin-right: 8px;">{{ $languages[$currentLocale]['flag'] ?? '🇫🇷' }}</span>
        <span style="font-size: 0.9em; color: #2a1620; font-weight: 600;">{{ $languages[$currentLocale]['name'] ?? 'Français' }}</span>
        <span style="font-size: 0.7em; color: #666; margin-left: 8px; transform: rotate(0deg); transition: transform 0.3s;">▼</span>
    </div>

    <div class="nav-lang-menu" id="navLanguageMenu"
         style="position: absolute; top: 100%; right: 0; background: white; border-radius: 15px; 
                box-shadow: 0 8px 25px rgba(0,0,0,0.2); opacity: 0; visibility: hidden; 
                transform: translateY(-10px); transition: all 0.3s ease; z-index: 2000; min-width: 160px; margin-top: 8px;
                border: 2px solid rgba(42,22,32,0.1);">
        @foreach($languages as $code => $lang)
            <a href="{{ route('lang.switch', ['locale' => $code]) }}" 
               style="display: flex; align-items: center; padding: 12px 16px; text-decoration: none; 
                      color: #2a1620; transition: all 0.2s; font-size: 0.9em; font-weight: 500;
                      border-radius: {{ $loop->first ? '15px 15px 0 0' : ($loop->last ? '0 0 15px 15px' : '0') }};
                      {{ session('locale') == $code ? 'background: #e8f4f8; font-weight: 700; color: #2a1620;' : '' }}"
               onmouseover="this.style.background='{{ session('locale') == $code ? '#d4edda' : '#f8f9fa' }}'; this.style.transform='translateX(3px)'" 
               onmouseout="this.style.background='{{ session('locale') == $code ? '#e8f4f8' : 'transparent' }}'; this.style.transform='translateX(0)'">
                <span style="font-size: 1.3em; margin-right: 10px;">{{ $lang['flag'] }}</span>
                <span style="flex: 1;">{{ $lang['name'] }}</span>
                @if(session('locale') == $code)
                    <span style="color: #28a745; font-size: 1em; font-weight: bold;">✓</span>
                @endif
            </a>
        @endforeach
    </div>
</div>

<script>
function toggleNavLanguageMenu() {
    console.log('🌍 Toggle nav language menu clicked');
    const menu = document.getElementById('navLanguageMenu');
    const arrow = document.querySelector('.nav-language-switcher .current-lang span:last-child');
    
    // Fermer tous les autres menus de langue ouverts
    document.querySelectorAll('.nav-lang-menu').forEach(otherMenu => {
        if (otherMenu !== menu && otherMenu.style.opacity === '1') {
            otherMenu.style.opacity = '0';
            otherMenu.style.visibility = 'hidden';
            otherMenu.style.transform = 'translateY(-10px)';
        }
    });
    
    if (menu.style.opacity === '1') {
        menu.style.opacity = '0';
        menu.style.visibility = 'hidden';
        menu.style.transform = 'translateY(-10px)';
        if (arrow) arrow.style.transform = 'rotate(0deg)';
    } else {
        menu.style.opacity = '1';
        menu.style.visibility = 'visible';
        menu.style.transform = 'translateY(0)';
        if (arrow) arrow.style.transform = 'rotate(180deg)';
    }
}

// Fermer le menu si on clique ailleurs
document.addEventListener('click', function(event) {
    const switcher = document.querySelector('.nav-language-switcher');
    if (switcher && !switcher.contains(event.target)) {
        const menu = document.getElementById('navLanguageMenu');
        const arrow = document.querySelector('.nav-language-switcher .current-lang span:last-child');
        if (menu) {
            menu.style.opacity = '0';
            menu.style.visibility = 'hidden';
            menu.style.transform = 'translateY(-10px)';
        }
        if (arrow) {
            arrow.style.transform = 'rotate(0deg)';
        }
    }
});

// S'assurer que le script s'exécute après le chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    console.log('🌍 Language switcher initialized');
});
</script>
