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
        
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        return $next($request);
    }
}
