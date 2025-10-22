<?php

namespace App\Http\Controllers;

use App\Models\Saveur;
use Illuminate\Http\Request;

class SaveurController extends Controller
{
    public function index()
    {
        $saveurs = Saveur::orderBy('nom_saveur')->get();
        return view('saveurs.index', compact('saveurs'));
    }

    public function create()
    {
        return view('saveurs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_saveur' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Saveur::create($data);
        return redirect()->route('saveurs.index')->with('success', 'Saveur ajoutée.');
    }

    public function show(Saveur $saveur)
    {
        return view('saveurs.show', compact('saveur'));
    }

    public function edit(Saveur $saveur)
    {
        return view('saveurs.edit', compact('saveur'));
    }

    public function update(Request $request, Saveur $saveur)
    {
        $data = $request->validate([
            'nom_saveur' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $saveur->update($data);
        return redirect()->route('saveurs.index')->with('success', 'Saveur modifiée.');
    }

    public function destroy(Saveur $saveur)
    {
        $saveur->delete();
        return redirect()->route('saveurs.index')->with('success', 'Saveur supprimée.');
    }

    
}
