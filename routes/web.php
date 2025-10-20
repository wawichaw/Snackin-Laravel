<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\BiscuitController;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Ici sont définies toutes les routes web de l'application Snackin.
| Nous avons créé deux systèmes principaux :
| 1. Système de commandes de biscuits
| 2. Système d'affichage du menu des biscuits
|
*/

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
// Ces routes permettent aux clients de commander des boîtes de biscuits
// - GET /commandes : Affiche le formulaire de commande
// - POST /commandes : Traite la commande soumise

Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.add');

// ============================================================================
// ROUTES POUR LE SYSTÈME DE BISCUITS (MENU)
// ============================================================================
// Ces routes permettent d'afficher le menu des biscuits et de gérer les commentaires
// - GET /biscuits : Affiche la liste de tous les biscuits disponibles
// - GET /biscuit : Alias au singulier pour la même fonctionnalité
// - GET /biscuits/{id}/commentaires : Affiche les commentaires d'un biscuit spécifique
// - GET /biscuits/{id}/ajouter-commentaire : Formulaire pour ajouter un commentaire

// Routes de test pour le développement
Route::get('/biscuits-test', function () {
    return 'Test route biscuits fonctionne !';
});

Route::get('/biscuits-simple', function () {
    $biscuits = \App\Models\Biscuit::all();
    return view('biscuit', ['biscuits' => $biscuits, 'supprimes' => collect([])]);
});

// Routes principales pour les biscuits
Route::get('/biscuits', [BiscuitController::class, 'index'])->name('biscuits.index');
Route::get('/biscuit', [BiscuitController::class, 'index'])->name('biscuit.index'); // Alias au singulier
Route::get('/biscuits/{id}/commentaires', [BiscuitController::class, 'commentaires'])->name('biscuits.commentaires');
Route::get('/biscuits/{id}/ajouter-commentaire', [BiscuitController::class, 'ajouterCommentaire'])->name('biscuits.ajouter-commentaire');

// ============================================================================
// ROUTES D'ADMINISTRATION DES BISCUITS
// ============================================================================
// Ces routes permettent aux administrateurs de gérer les biscuits
// - GET /admin-biscuits : Interface d'administration
// - GET /admin-biscuits/{action} : Actions comme 'add' pour ajouter un biscuit
// - GET /admin-biscuits/{action}/{id} : Actions avec ID comme 'edit/1' ou 'delete/1'

Route::get('/admin-biscuits', [BiscuitController::class, 'admin'])->name('admin.biscuits');
Route::get('/admin-biscuits/{action}', [BiscuitController::class, 'admin'])->name('admin.biscuits.action');
Route::get('/admin-biscuits/{action}/{id}', [BiscuitController::class, 'admin'])->name('admin.biscuits.action.id');