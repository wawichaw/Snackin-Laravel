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
    public function index(Request $request)
    {
        $query = Biscuit::with('saveur');

        // Recherche par nom ou description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_biscuit', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filtre par saveur
        if ($request->filled('saveur')) {
            $saveur = $request->saveur;
            $query->whereHas('saveur', function($q) use ($saveur) {
                $q->where('nom_saveur', 'LIKE', $saveur);
            });
        }

        // Tri par prix
        if ($request->filled('prix')) {
            $query->orderBy('prix', $request->prix);
        }

        $biscuits = $query->get();
        
        // Récupérer les saveurs autorisées depuis le modèle Saveur
        $allowedSaveurs = \App\Models\Saveur::pluck('nom_saveur')->map(function($saveur) {
            return strtolower($saveur);
        })->toArray();
        
        // Map des emojis
        $emojiMap = [
            'original' => '🍪',
            'chocolat' => '🍫',
            'caramel' => '🍮',
            'vanille' => '🌼',
            'smores' => '🔥🍫',
            'oreo' => '🍪',
        ];

        return view('biscuits.index', compact('biscuits', 'allowedSaveurs', 'emojiMap'));
    }

    public function create()
    {
        $saveurs = \App\Models\Saveur::orderBy('nom_saveur')->get();
        return view('biscuits.create', compact('saveurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_biscuit' => 'required',
            'prix' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'saveur_id' => 'required|exists:saveurs,id',
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
            'saveur_id' => 'required|exists:saveurs,id',
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

     public function search(Request $request)
    {
        $search = $request->get('q');
        $biscuits = Biscuit::with('saveur')
            ->where('nom_biscuit', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->limit(5)
            ->get()
            ->map(function($biscuit) {
                return [
                    'id' => $biscuit->id,
                    'nom_biscuit' => $biscuit->nom_biscuit,
                    'nom_saveur' => $biscuit->saveur ? $biscuit->saveur->nom_saveur : null,
                    'emoji' => $biscuit->saveur ? $this->getEmojiForSaveur($biscuit->saveur->nom_saveur) : '🍪'
                ];
            });
        
        return response()->json($biscuits);
    }

    private function getEmojiForSaveur($saveur)
    {
        $emojiMap = [
            'original' => '🍪',
            'chocolat' => '🍫',
            'caramel' => '🍮',
            'vanille' => '🌼',
            'smores' => '🔥🍫',
            'oreo' => '🍪',
        ];

        return $emojiMap[strtolower($saveur)] ?? '🍪';
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
