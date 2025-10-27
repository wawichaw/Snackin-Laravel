<?php

namespace App\Http\Controllers;

use App\Models\Biscuit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class BiscuitController extends Controller
{
    //Autocomplétion

    //détails
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

     public function autocomplete(Request $request)
    {
        $search = $request->search;
        $biscuits = Biscuit::orderby('nom_biscuit','asc')
                    ->select('id','nom_biscuit')
                    ->where('nom_biscuit', 'LIKE', '%'.$search. '%')
                    ->get();
                    $response = array();
                    foreach($biscuits as $biscuit){
                        $response[] = array(
                            'value' => $biscuit->id,
                            'label' => $biscuit->nom_biscuit
                        );
                    }
        return response()->json($response);
    } 

    //détails biscuit
    public function details($id)
    {
        $biscuit = DB::table('biscuits')
        ->join('saveurs', 'biscuits.saveur_id', '=', 'saveurs.id')
        ->select('biscuits.*', 'saveurs.nom_saveur')
        ->where('id', $id)->first();
        -first();
        return view('biscuits.details', compact('biscuit'));
    }

}
