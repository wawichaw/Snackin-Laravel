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

// Commentaires publics (accessibles à tous)
Route::get('/commentaires', [CommentaireController::class, 'public'])->name('commentaires.public');
Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');

// Commentaires imbriqués sous un biscuit (admin)
Route::get('/biscuits/{biscuit}/commentaires',        [CommentaireController::class, 'index'])->name('biscuits.commentaires.index');
Route::get('/biscuits/{biscuit}/commentaires/create', [CommentaireController::class, 'create'])->name('biscuits.commentaires.create');
Route::post('/biscuits/{biscuit}/commentaires',       [CommentaireController::class, 'store'])->name('biscuits.commentaires.store');

// Gestion admin des commentaires (accès restreint aux administrateurs)
Route::middleware('auth')->group(function () {
    Route::get('/admin/commentaires', [CommentaireController::class, 'admin'])->name('commentaires.admin');
    Route::get('/admin/commentaires/{commentaire}', [CommentaireController::class, 'showAdmin'])->name('commentaires.show-admin');
    Route::get('/admin/commentaires/{commentaire}/edit', [CommentaireController::class, 'editAdmin'])->name('commentaires.edit-admin');
    Route::put('/admin/commentaires/{commentaire}', [CommentaireController::class, 'updateAdmin'])->name('commentaires.update-admin');
    Route::post('/admin/commentaires/{commentaire}/moderate', [CommentaireController::class, 'moderate'])->name('commentaires.moderate');
    Route::delete('/admin/commentaires/{commentaire}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy-admin');
});
// Route pour l'autocomplétion de la recherche
Route::get('/biscuits/search', [BiscuitController::class, 'search'])->name('biscuits.search');

// Saveurs (CRUD) - Accès restreint aux administrateurs
Route::middleware('auth')->group(function () {
    Route::resource('saveurs', SaveurController::class);
});

// Commandes (formulaire public + envoi + page admin)
Route::middleware('auth')->group(function () {
	// affichage du formulaire (doit être connecté)
	Route::get('/commandes',  [CommandeController::class, 'create'])->name('commandes.create');
	// soumettre commande
	Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
	// page "mes commandes" pour utilisateur connecté
	Route::get('/mes-commandes', [CommandeController::class, 'userOrders'])->name('mes.commandes');
});

// Routes admin pour les commandes (contrôlées côté controller)
Route::middleware('auth')->group(function () {
    Route::get('/admin/commandes', [CommandeController::class, 'index'])->name('commandes.index'); // liste admin
    Route::get('/admin/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show'); // voir commande
    Route::get('/admin/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit'); // éditer commande
    Route::put('/admin/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update'); // mettre à jour
    Route::delete('/admin/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy'); // supprimer
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\LocalizationController;

Route::get('/lang/{locale}', [LocalizationController::class, 'index']);
