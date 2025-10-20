<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Biscuit;
use Illuminate\Http\Request;

/**
 * ============================================================================
 * CONTRÔLEUR POUR LA GESTION DES COMMANDES
 * ============================================================================
 * 
 * Ce contrôleur gère tout ce qui concerne les commandes de boîtes de biscuits.
 * 
 * FONCTIONNALITÉS :
 * - Affichage du formulaire de commande
 * - Traitement et validation des commandes
 * - Vérification des quantités par rapport à la taille de boîte
 * - Gestion des erreurs et messages de succès
 * 
 * CONVERSION DEPUIS PHP VERS LARAVEL :
 * - Accès direct aux propriétés : $biscuit->nom_biscuit au lieu de $biscuit->getNomBiscuit()
 * - Validation Laravel avec $request->validate()
 * - Redirection avec messages de session
 * - Utilisation des relations Eloquent
 */

class CommandeController extends Controller
{
    /**
     * Afficher la page de commande
     */
    public function index()
    {
        // Récupérer tous les biscuits disponibles
        $biscuits = Biscuit::all();
        
        return view('commande', compact('biscuits'));
    }
    
    /**
     * Traiter la commande
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'taille_boite' => 'required|in:4,6,12',
            'nom_client' => 'required|string|max:255',
            'email_client' => 'required|email|max:255',
            'quantites' => 'required|array',
            'quantites.*' => 'integer|min:0|max:12'
        ]);
        
        // Vérifier que le total des quantités correspond à la taille de boîte
        $totalQuantites = array_sum($request->quantites);
        $tailleBoite = (int) $request->taille_boite;
        
        if ($totalQuantites !== $tailleBoite) {
            return back()->withErrors([
                'quantites' => "Le total des quantités ($totalQuantites) doit correspondre à la taille de boîte choisie ($tailleBoite)."
            ])->withInput();
        }
        
        // Vérifier qu'au moins un biscuit est sélectionné
        $quantitesNonZero = array_filter($request->quantites, function($q) {
            return $q > 0;
        });
        
        if (empty($quantitesNonZero)) {
            return back()->withErrors([
                'quantites' => 'Vous devez sélectionner au moins un biscuit.'
            ])->withInput();
        }
        
        // Ici vous pouvez traiter la commande (sauvegarder en base, envoyer un email, etc.)
        // Pour l'instant, on simule un succès
        
        $message_succes = "Commande passée avec succès ! Vous recevrez un email de confirmation.";
        
        return redirect()->route('commandes.index')->with('message_succes', $message_succes);
    }
}
