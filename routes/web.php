<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiscuitController;
use App\Http\Controllers\CommandeController;     
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\SaveurController;

// Pages simples
Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');    
// Biscuits (CRUD)
Route::resource('biscuits', BiscuitController::class);
// Alias /biscuit -> index (si tu veux garder l’ancien lien)
Route::get('/biscuit', [BiscuitController::class, 'index'])->name('biscuit.index');

// Commentaires imbriqués sous un biscuit
Route::get('/biscuits/{biscuit}/commentaires',        [CommentaireController::class, 'index'])->name('biscuits.commentaires.index');
Route::get('/biscuits/{biscuit}/commentaires/create', [CommentaireController::class, 'create'])->name('biscuits.commentaires.create');
Route::post('/biscuits/{biscuit}/commentaires',       [CommentaireController::class, 'store'])->name('biscuits.commentaires.store');

// Saveurs (CRUD)
Route::resource('saveurs', SaveurController::class);

// Commandes (formulaire public + envoi + page admin)
Route::get('/commandes',  [CommandeController::class, 'create'])->name('commandes.create'); // afficher formulaire
Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');   // soumettre commande
Route::get('/admin/commandes', [CommandeController::class, 'index'])->name('commandes.index'); // liste admin
