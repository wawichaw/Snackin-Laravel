<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App; 



class LocalizationController extends Controller
{
     /**
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index($locale) : RedirectResponse
    {
       $available = ['fr', 'en', 'es']; 
        if (!in_array($locale, $available)) {
            $locale = config('app.locale');
        }
        
        // Debug
        \Log::info('🌍 Language switch requested', [
            'requested_locale' => $locale,
            'current_app_locale' => app()->getLocale(),
            'session_before' => session('locale'),
        ]);
        
        App::setLocale($locale);
        session()->put('locale', $locale);
        session()->save(); // Force save
        
        \Log::info('🌍 Language switch completed', [
            'new_app_locale' => app()->getLocale(),
            'session_after' => session('locale'),
        ]);
        
        return redirect()->back();
    }
}
