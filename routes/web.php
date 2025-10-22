<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiscuitController;
use App\Http\Controllers\SaveurController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\CommandeCrudController;


// ============================================================================
// ROUTES PRINCIPALES DE L'APPLICATION
// ============================================================================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

// ============================================================================
// ROUTES POUR LE SYSTÈME DE COMMANDES
// ============================================================================
Route::resource('saveurs', SaveurController::class);

// ============================================================================
// ROUTES POUR LE SYSTÈME DE BISCUITS
// ============================================================================

// Interface CRUD complète pour les biscuits (Créer, Lire, Éditer, Effacer)
Route::resource('biscuits', BiscuitController::class);
Route::resource('commandes-admin', CommandeCrudController::class)
    ->parameters(['commandes-admin' => 'commande']);
    
Route::resource('commentaires', CommentaireController::class);


