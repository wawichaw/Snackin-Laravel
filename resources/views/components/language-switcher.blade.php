@php
    $currentLocale = session('locale', config('app.locale')); 
    $languages = [
        'fr' => ['flag' => '🇫🇷', 'name' => 'Français', 'native' => 'Français'], 
        'en' => ['flag' => '🇺🇸', 'name' => 'English', 'native' => 'English'], 
        'es' => ['flag' => '🇪🇸', 'name' => 'Español', 'native' => 'Español']
    ];
@endphp

<div class="language-switcher" style="position: relative; display: inline-block;">
    <div class="current-language" 
         style="display: flex; align-items: center; cursor: pointer; padding: 6px 10px; 
                background: rgba(255,255,255,0.8); border-radius: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                transition: all 0.2s ease; font-weight: 400; font-size: 0.85em; border: 1px solid rgba(0,0,0,0.1);
                min-width: 60px; justify-content: center;"
         onclick="toggleLanguageMenu()"
         onmouseover="this.style.background='rgba(255,255,255,0.9)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.15)'"
         onmouseout="this.style.background='rgba(255,255,255,0.8)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
        <span style="font-size: 1.1em; margin-right: 4px;">{{ $languages[$currentLocale]['flag'] ?? '🇫🇷' }}</span>
        <span style="font-size: 0.6em; color: #666; transform: rotate(0deg); transition: transform 0.2s;">▼</span>
    </div>

    <div class="language-menu" id="languageMenu"
         style="position: absolute; top: 100%; right: 0; background: white; border-radius: 8px; 
                box-shadow: 0 3px 10px rgba(0,0,0,0.15); opacity: 0; visibility: hidden; 
                transform: translateY(-5px); transition: all 0.2s ease; z-index: 2000; min-width: 120px; margin-top: 3px;
                border: 1px solid rgba(0,0,0,0.1);">
        @foreach($languages as $code => $lang)
            <a href="{{ route('lang.switch', ['locale' => $code]) }}" 
               style="display: flex; align-items: center; padding: 8px 12px; text-decoration: none; 
                      color: #333; transition: all 0.2s; border-radius: {{ $loop->first ? '8px 8px 0 0' : ($loop->last ? '0 0 8px 8px' : '0') }};
                      font-size: 0.85em; font-weight: 400;
                      {{ session('locale') == $code ? 'background: #f0f8ff; font-weight: 500;' : '' }}"
               onmouseover="this.style.background='#f5f5f5'" 
               onmouseout="this.style.background='{{ session('locale') == $code ? '#f0f8ff' : 'transparent' }}'">
                <span style="font-size: 1.1em; margin-right: 8px;">{{ $lang['flag'] }}</span>
                <span style="flex: 1;">{{ $lang['native'] }}</span>
                @if(session('locale') == $code)
                    <span style="color: #007bff; font-size: 0.8em;">✓</span>
                @endif
            </a>
        @endforeach
    </div>
</div>

<script>
function toggleLanguageMenu() {
    console.log('🌍 Toggle language menu clicked');
    const menu = document.getElementById('languageMenu');
    const arrow = document.querySelector('.current-language span:last-child');
    
    if (menu.style.opacity === '1') {
        menu.style.opacity = '0';
        menu.style.visibility = 'hidden';
        menu.style.transform = 'translateY(-10px)';
        arrow.style.transform = 'rotate(0deg)';
    } else {
        menu.style.opacity = '1';
        menu.style.visibility = 'visible';
        menu.style.transform = 'translateY(0)';
        arrow.style.transform = 'rotate(180deg)';
    }
}

// Fermer le menu si on clique ailleurs
document.addEventListener('click', function(event) {
    const switcher = document.querySelector('.language-switcher');
    if (switcher && !switcher.contains(event.target)) {
        const menu = document.getElementById('languageMenu');
        const arrow = document.querySelector('.current-language span:last-child');
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
</script>
