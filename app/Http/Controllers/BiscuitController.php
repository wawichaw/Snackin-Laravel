<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Biscuit;
use App\Models\Saveur;
use Illuminate\Http\Request;

/**
 * ============================================================================
 * CONTRÔLEUR POUR LA GESTION DES BISCUITS
 * ============================================================================
 * 
 * Ce contrôleur gère l'affichage du menu des biscuits et les actions d'administration.
 * 
 * FONCTIONNALITÉS :
 * - Affichage de la liste des biscuits avec leurs saveurs
 * - Gestion des commentaires (à implémenter)
 * - Actions d'administration (ajouter, modifier, supprimer, restaurer)
 * - Gestion des permissions admin
 * - Support des suppressions logiques (SoftDeletes)
 * 
 * CONVERSION DEPUIS PHP VERS LARAVEL :
 * - Relations Eloquent : $biscuit->saveur au lieu de Saveur::getNomById()
 * - SoftDeletes pour les suppressions logiques
 * - Gestion des permissions avec auth()->user()->is_admin
 * - Utilisation des routes nommées Laravel
 * - Gestion des erreurs avec try/catch
 */

class BiscuitController extends Controller
{
    /**
     * Afficher la liste des biscuits
     */
    public function index()
    {
        try {
            // Version simplifiée pour debug
            $biscuits = Biscuit::all();
            
            return view('biscuit', [
                'biscuits' => $biscuits,
                'supprimes' => collect([])
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une vue simple pour debug
            return view('biscuit', [
                'biscuits' => collect([]),
                'supprimes' => collect([]),
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Afficher les commentaires d'un biscuit
     */
    public function commentaires($id)
    {
        $biscuit = Biscuit::with('saveur')->findOrFail($id);
        // Ici vous pouvez ajouter la logique pour récupérer les commentaires
        return view('commentaires', compact('biscuit'));
    }
    
    /**
     * Afficher le formulaire d'ajout de commentaire
     */
    public function ajouterCommentaire($id)
    {
        $biscuit = Biscuit::findOrFail($id);
        return view('ajouter-commentaire', compact('biscuit'));
    }
    
    /**
     * Actions d'administration
     */
    public function admin($action = null, $id = null)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Accès non autorisé');
        }
        
        switch ($action) {
            case 'add':
                $saveurs = Saveur::all();
                return view('admin.biscuits.add', compact('saveurs'));
                
            case 'edit':
                $biscuit = Biscuit::with('saveur')->findOrFail($id);
                $saveurs = Saveur::all();
                return view('admin.biscuits.edit', compact('biscuit', 'saveurs'));
                
            case 'delete':
                $biscuit = Biscuit::findOrFail($id);
                $biscuit->delete();
                return redirect()->route('biscuits.index')->with('success', 'Biscuit supprimé avec succès');
                
            case 'restore':
                $biscuit = Biscuit::onlyTrashed()->findOrFail($id);
                $biscuit->restore();
                return redirect()->route('biscuits.index')->with('success', 'Biscuit restauré avec succès');
                
            default:
                return redirect()->route('biscuits.index');
        }
    }
}
