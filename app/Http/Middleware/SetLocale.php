<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer la langue de la session ou utiliser celle par défaut
        $locale = session('locale', config('app.locale'));
        
        // Vérifier que la langue est supportée
        $supportedLocales = ['fr', 'en', 'es'];
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale');
        }
        
        // Définir la langue pour l'application
        App::setLocale($locale);
        
        return $next($request);
    }
}
