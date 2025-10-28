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
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
