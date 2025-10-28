<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $sessionLocale = session('locale');
        $currentLocale = app()->getLocale();
        
        // Debug
        \Log::info('🔧 Localization Middleware', [
            'session_locale' => $sessionLocale,
            'current_app_locale' => $currentLocale,
            'url' => $request->url(),
        ]);
        
        if (session()->has('locale')) {
            $newLocale = session()->get('locale');
            App::setLocale($newLocale);
            
            \Log::info('🔧 Locale set to: ' . $newLocale);
        }
        
        return $next($request);
    }
}
