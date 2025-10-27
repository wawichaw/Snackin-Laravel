<?php

namespace App\Http\Controllers;

use App\Models\Biscuit;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function create()
    {
        $biscuits = Biscuit::all();

        return view('commande', compact('biscuits'));
    }

    /**
     * Page admin: lister toutes les commandes
     */
    public function index()
    {
        // restreindre l'accès aux administrateurs
        if (!Auth::check() || (!Auth::user()->is_admin && Auth::user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        $commandes = Commande::orderBy('created_at', 'desc')->get();
        return view('commandes_admin.index', compact('commandes'));
    }

    /**
     * Afficher une commande spécifique (admin)
     */
    public function show(Commande $commande)
    {
        if (!Auth::check() || (!Auth::user()->is_admin && Auth::user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        return view('commandes_admin.show', compact('commande'));
    }

    /**
     * Éditer une commande (admin)
     */
    public function edit(Commande $commande)
    {
        if (!Auth::check() || (!Auth::user()->is_admin && Auth::user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        return view('commandes_admin.edit', compact('commande'));
    }

    /**
     * Mettre à jour une commande (admin)
     */
    public function update(Request $request, Commande $commande)
    {
        if (!Auth::check() || (!Auth::user()->is_admin && Auth::user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        $data = $request->validate([
            'client_nom' => 'required|string|max:255',
            'client_email' => 'required|email',
            'status' => 'required|string|in:en_attente,en_preparation,prete,livree,annulee',
            'total_prix' => 'nullable|numeric|min:0',
        ]);

        $commande->update($data);
        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès.');
    }

    /**
     * Supprimer une commande (admin)
     */
    public function destroy(Commande $commande)
    {
        if (!Auth::check() || (!Auth::user()->is_admin && Auth::user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès.');
    }

    /**
     * Afficher les commandes du client connecté
     */
    public function userOrders()
    {
        if (!\Auth::check()) {
            abort(403);
        }

        $email = \Auth::user()->email;
        $commandes = Commande::where('client_email', $email)->orderBy('created_at', 'desc')->get();
        return view('commandes_user.index', compact('commandes'));
    }

    // Enregistre la commande (POST)
    public function store(Request $request)
    {
        $data = $request->validate([
            'taille_boite' => 'nullable|string',
            'quantites'    => 'nullable|array',
            'email_client' => 'required|email',
            'nom_client'   => 'required|string',
        ]);

        $commande = new Commande();
        $commande->utilisateur_id = Auth::id(); // Ajouter l'ID de l'utilisateur connecté
        $commande->client_nom   = $request->input('nom_client');
        $commande->client_email = $request->input('email_client');
        
        // Calculer le prix total basé sur la taille de boîte
        $tailleBoite = $request->input('taille_boite');
        $prixBoite = $this->calculerPrixBoite($tailleBoite);
        
        $commande->details_json = json_encode([
            'taille'    => $tailleBoite,
            'quantites' => $request->input('quantites', []),
        ]);
        $commande->status = 'en_attente'; // Statut par défaut
        $commande->total_prix = $prixBoite; // Prix calculé
        $commande->save();

        // rediriger en flashant un message de succès
        return redirect()->route('commandes.create')->with('message_succes', "Commande réussie pour {$prixBoite}$. Merci !");
    }

    /**
     * Calculer le prix d'une boîte selon sa taille
     */
    private function calculerPrixBoite($tailleBoite)
    {
        $prixParTaille = [
            '4' => 15.00,
            '6' => 20.00,
            '12' => 35.00,
        ];

        return $prixParTaille[$tailleBoite] ?? 0.00;
    }
}
