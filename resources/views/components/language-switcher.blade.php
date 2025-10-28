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
         style="display: flex; align-items: center; cursor: pointer; padding: 12px 18px; 
                background: rgba(255,255,255,0.95); border-radius: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);
                transition: all 0.3s ease; font-weight: 600; font-size: 1em; border: 2px solid rgba(42,22,32,0.2);
                min-width: 150px; justify-content: space-between;"
         onclick="toggleLanguageMenu()"
         onmouseover="this.style.background='rgba(255,255,255,1)'; this.style.transform='translateY(-3px) scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.2)'"
         onmouseout="this.style.background='rgba(255,255,255,0.95)'; this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.15)'">
        <span style="font-size: 1.4em; margin-right: 8px;">{{ $languages[$currentLocale]['flag'] ?? '🇫🇷' }}</span>
        <span class="language-name" style="margin-right: 8px; min-width: 80px; text-align: left; font-size: 1em; color: #2a1620; font-weight: 700;">
            {{ $languages[$currentLocale]['name'] ?? 'Français' }}
        </span>
        <span style="font-size: 0.8em; color: #666; transform: rotate(0deg); transition: transform 0.3s;">▼</span>
    </div>

    <div class="language-menu" id="languageMenu"
         style="position: absolute; top: 100%; right: 0; background: white; border-radius: 18px; 
                box-shadow: 0 10px 30px rgba(0,0,0,0.25); opacity: 0; visibility: hidden; 
                transform: translateY(-15px); transition: all 0.3s ease; z-index: 2000; min-width: 200px; margin-top: 10px;
                border: 3px solid rgba(42,22,32,0.15);">
        @foreach($languages as $code => $lang)
            <a href="{{ route('lang.switch', ['locale' => $code]) }}" 
               style="display: flex; align-items: center; padding: 16px 20px; text-decoration: none; 
                      color: #2a1620; transition: all 0.3s; border-radius: {{ $loop->first ? '18px 18px 0 0' : ($loop->last ? '0 0 18px 18px' : '0') }};
                      font-size: 1.05em; font-weight: 500;
                      {{ session('locale') == $code ? 'background: linear-gradient(135deg, #e8f4f8, #d4edda); font-weight: 700; color: #2a1620;' : '' }}"
               onmouseover="this.style.background='{{ session('locale') == $code ? 'linear-gradient(135deg, #d4edda, #c3e9d0)' : 'linear-gradient(135deg, #f8f9fa, #e9ecef)' }}'; this.style.transform='translateX(5px)'; this.style.boxShadow='inset 4px 0 0 #28a745'" 
               onmouseout="this.style.background='{{ session('locale') == $code ? 'linear-gradient(135deg, #e8f4f8, #d4edda)' : 'transparent' }}'; this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                <span style="font-size: 1.6em; margin-right: 12px;">{{ $lang['flag'] }}</span>
                <span style="flex: 1; font-weight: inherit;">{{ $lang['native'] }}</span>
                @if(session('locale') == $code)
                    <span style="color: #28a745; font-size: 1.3em; font-weight: bold;">✓</span>
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
