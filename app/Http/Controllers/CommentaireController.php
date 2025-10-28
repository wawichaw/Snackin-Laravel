<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Biscuit;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function index()
    {
        $commentaires = Commentaire::with('biscuit')->orderByDesc('id')->paginate(20);
        return view('commentaires.index', compact('commentaires'));
    }

    public function create()
    {
        $biscuits = Biscuit::orderBy('nom_biscuit')->get();
        return view('commentaires.create', compact('biscuits'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'biscuit_id'     => 'required|exists:biscuits,id',
            'utilisateur_id' => 'nullable|integer',
            'texte'          => 'required|string',
            'note'           => 'nullable|integer|min:1|max:5',
            'nom_visiteur'   => 'nullable|string|max:255', // Pour les utilisateurs non connectés
            'email_visiteur' => 'nullable|email|max:255', // Pour les utilisateurs non connectés
            'auteur_affiche' => 'nullable|string|max:150',
            'modere'         => 'nullable|boolean',
        ]);

        // Si l'utilisateur n'est pas connecté, utiliser les champs visiteur
        if (!auth()->check()) {
            $data['utilisateur_id'] = null;
            $data['nom_visiteur'] = $request->input('nom_visiteur');
            $data['email_visiteur'] = $request->input('email_visiteur');
        } else {
            $data['utilisateur_id'] = auth()->id();
            $data['nom_visiteur'] = null;
            $data['email_visiteur'] = null;
        }

        // Gérer le champ modere (par défaut true pour nouveaux commentaires pour affichage immédiat)
        $data['modere'] = $request->has('modere') ? (bool) $request->modere : true;

        // Déterminer l'auteur à afficher
        if (!auth()->check()) {
            $data['auteur_affiche'] = $data['nom_visiteur'] ?? 'Anonyme';
        } else {
            $data['auteur_affiche'] = auth()->user()->name;
        }

        // Le mapping texte->contenu se fait automatiquement via le mutateur setTexteAttribute
        Commentaire::create($data);
        return redirect()->route('commentaires.public')->with('success', 'Commentaire ajouté avec succès !');
    }

    /**
     * Page publique pour voir et ajouter des commentaires
     */
    public function public()
    {
        $commentaires = Commentaire::with('biscuit')
            ->where('modere', true)  // N'afficher que les commentaires approuvés
            ->orderByDesc('created_at')
            ->paginate(10);
        $biscuits = Biscuit::orderBy('nom_biscuit')->get();
        
        return view('commentaires.public', compact('commentaires', 'biscuits'));
    }

    public function show(Commentaire $commentaire)
    {
        $commentaire->load('biscuit');
        return view('commentaires.show', compact('commentaire'));
    }

    public function edit(Commentaire $commentaire)
    {
        $biscuits = Biscuit::orderBy('nom_biscuit')->get();
        return view('commentaires.edit', compact('commentaire', 'biscuits'));
    }

    public function update(Request $request, Commentaire $commentaire)
    {
        $data = $request->validate([
            'biscuit_id'     => 'required|exists:biscuits,id',
            'utilisateur_id' => 'nullable|integer',
            'texte'          => 'required|string',
            'note'           => 'nullable|integer|min:1|max:5',
            'auteur_affiche' => 'nullable|string|max:150',
        ]);

        // Le mapping texte->contenu se fait automatiquement via le mutateur setTexteAttribute
        $commentaire->update($data);
        return redirect()->route('commentaires.index')->with('success', 'Commentaire modifié.');
    }

    public function destroy(Commentaire $commentaire)
    {
        $commentaire->delete();
        return redirect()->route('commentaires.index')->with('success', 'Commentaire supprimé.');
    }

    /**
     * Page admin pour gérer tous les commentaires
     */
    public function admin()
    {
        // Restreindre l'accès aux administrateurs
        if (!auth()->check() || (!auth()->user()->is_admin && auth()->user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        $commentaires = Commentaire::with(['biscuit', 'utilisateur'])
            ->orderByDesc('created_at')
            ->paginate(20);
        
        return view('commentaires.admin', compact('commentaires'));
    }

    /**
     * Modérer un commentaire (approuver/rejeter)
     */
    public function moderate(Request $request, Commentaire $commentaire)
    {
        if (!auth()->check() || (!auth()->user()->is_admin && auth()->user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        if ($request->action === 'approve') {
            $commentaire->update(['modere' => true]);
            $message = 'Commentaire approuvé.';
        } else {
            // Rejeter = supprimer directement le commentaire
            $commentaire->delete();
            $message = 'Commentaire rejeté et supprimé.';
        }

        return redirect()->route('commentaires.admin')->with('success', $message);
    }

    /**
     * Afficher un commentaire spécifique (admin)
     */
    public function showAdmin(Commentaire $commentaire)
    {
        if (!auth()->check() || (!auth()->user()->is_admin && auth()->user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        $commentaire->load(['biscuit', 'utilisateur']);
        return view('commentaires.show-admin', compact('commentaire'));
    }

    /**
     * Éditer un commentaire (admin)
     */
    public function editAdmin(Commentaire $commentaire)
    {
        if (!auth()->check() || (!auth()->user()->is_admin && auth()->user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        $biscuits = Biscuit::orderBy('nom_biscuit')->get();
        return view('commentaires.edit-admin', compact('commentaire', 'biscuits'));
    }

    /**
     * Mettre à jour un commentaire (admin)
     */
    public function updateAdmin(Request $request, Commentaire $commentaire)
    {
        if (!auth()->check() || (!auth()->user()->is_admin && auth()->user()->role !== 'ADMIN')) {
            abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
        }

        $data = $request->validate([
            'biscuit_id'     => 'required|exists:biscuits,id',
            'texte'          => 'required|string',
            'note'           => 'nullable|integer|min:1|max:5',
            'nom_visiteur'   => 'nullable|string|max:255',
            'email_visiteur' => 'nullable|email|max:255',
            'auteur_affiche' => 'nullable|string|max:150',
            'modere'         => 'nullable|boolean',
        ]);

        // Gérer le champ modere correctement pour les checkboxes
        $data['modere'] = $request->has('modere') ? (bool) $request->modere : false;

        // Le mapping texte->contenu se fait automatiquement via le mutateur setTexteAttribute
        $commentaire->update($data);
        return redirect()->route('commentaires.admin')->with('success', 'Commentaire mis à jour avec succès.');
    }
}
