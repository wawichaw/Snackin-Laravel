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
        ]);

        Commentaire::create($data);
        return redirect()->route('commentaires.index')->with('success', 'Commentaire ajouté.');
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
        ]);

        $commentaire->update($data);
        return redirect()->route('commentaires.index')->with('success', 'Commentaire modifié.');
    }

    public function destroy(Commentaire $commentaire)
    {
        $commentaire->delete();
        return redirect()->route('commentaires.index')->with('success', 'Commentaire supprimé.');
    }
}
