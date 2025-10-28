<!DOCTYPE html>
<html>
<head>
    <title>🧪 Debug Langue</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f8f9fa; }
        .debug-card { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; border-left: 4px solid #007bff; }
        .success { border-left-color: #28a745; }
        .error { border-left-color: #dc3545; }
        .lang-btn { padding: 12px 20px; margin: 5px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; display: inline-block; }
        .current { background: #28a745; }
    </style>
</head>
<body>
    <h1>🧪 Debug du Système de Langue</h1>
    
    <div class="debug-card">
        <h3>📊 État Actuel</h3>
        <p><strong>App Locale:</strong> {{ app()->getLocale() }}</p>
        <p><strong>Session Locale:</strong> {{ session('locale', 'NON DÉFINIE') }}</p>
        <p><strong>Config App Locale:</strong> {{ config('app.locale') }}</p>
        <p><strong>Session Driver:</strong> {{ config('session.driver') }}</p>
        <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
    </div>
    
    <div class="debug-card">
        <h3>🔄 Tester les Routes</h3>
        <a href="{{ route('lang.switch', 'fr') }}" class="lang-btn {{ app()->getLocale() == 'fr' ? 'current' : '' }}">🇫🇷 Français</a>
        <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ app()->getLocale() == 'en' ? 'current' : '' }}">🇺🇸 English</a>
        <a href="{{ route('lang.switch', 'es') }}" class="lang-btn {{ app()->getLocale() == 'es' ? 'current' : '' }}">🇪🇸 Español</a>
    </div>
    
    <div class="debug-card">
        <h3>📝 Session Data</h3>
        <pre>{{ print_r(session()->all(), true) }}</pre>
    </div>
    
    <div class="debug-card">
        <h3>🔧 Test JavaScript</h3>
        <button onclick="testLang()" style="padding: 10px 15px; background: #6c757d; color: white; border: none; border-radius: 5px;">Test Console</button>
        <div id="test-result" style="margin-top: 10px;"></div>
    </div>
    
    <div class="debug-card">
        <h3>🏠 Navigation</h3>
        <a href="{{ url('/') }}" style="color: #007bff;">← Retour à l'accueil</a>
    </div>
    
    <script>
    function testLang() {
        console.log('🧪 Debug Language Test');
        console.log('App Locale:', '{{ app()->getLocale() }}');
        console.log('Session Locale:', '{{ session('locale', 'NON DÉFINIE') }}');
        console.log('Current URL:', window.location.href);
        document.getElementById('test-result').innerHTML = '✅ Check console for details';
    }
    
    console.log('🌍 Debug page loaded');
    console.log('Current app locale:', '{{ app()->getLocale() }}');
    console.log('Session locale:', '{{ session('locale', 'NON DÉFINIE') }}');
    </script>
</body>
</html>
