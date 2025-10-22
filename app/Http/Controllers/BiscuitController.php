<?php

namespace App\Http\Controllers;

use App\Models\Biscuit;
use Illuminate\Http\Request;

class BiscuitController extends Controller
{
    public function index()
    {
        $biscuits = Biscuit::all();
        return view('biscuits.index', compact('biscuits'));
    }

    public function create()
    {
        return view('biscuits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_biscuit' => 'required',
            'prix' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable',
        ]);

        Biscuit::create($validated);

        return redirect()->route('biscuits.index')->with('success', 'Biscuit ajouté avec succès!');
    }

    public function edit(Biscuit $biscuit)
    {
        return view('biscuits.edit', compact('biscuit'));
    }

    public function update(Request $request, Biscuit $biscuit)
    {
        $validated = $request->validate([
            'nom_biscuit' => 'required',
            'prix' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable',
        ]);

        $biscuit->update($validated);

        return redirect()->route('biscuits.index')->with('success', 'Biscuit modifié!');
    }

    public function destroy(Biscuit $biscuit)
    {
        $biscuit->delete();

        return redirect()->route('biscuits.index')->with('success', 'Biscuit supprimé!');
    }
}
