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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        //téléversement image
        if($request->hasFile('image')){
            $imageName = time(). '.' . $request->image->extension();
            $request->image->move(public_path('Contenu/img'), $imageName);
            $validated['image'] = $imageName;
        }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        //si nouvelle image
        if($request->hasFile('image')) {
            // supprimer ancienne image
            if($biscuit->image && file_exists(public_path('Contenu/img/'. $biscuit->image))) {
                unlink(public_path('Contenu/img/' . $biscuit->image));
            }

            //enregistrer nouvelle image
            $imageName = time(). '.' . $request->image->extension();
            $request->image->move(public_path('Contenu/img'), $imageName);
            $validated['image'] = $imageName;

        }



        $biscuit->update($validated);

        return redirect()->route('biscuits.index')->with('success', 'Biscuit modifié!');
    }

    public function destroy(Biscuit $biscuit)
    {
        //suppression fichier image
        if($biscuit->image && file_exists(public_path('Contenu/img' . $biscuit->image))) {
            unlink(public_path('Contenu/img' . $biscuit->image));
        }

        $biscuit->delete();

        return redirect()->route('biscuits.index')->with('success', 'Biscuit supprimé!');
    }
}
