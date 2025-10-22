<?php

namespace App\Http\Controllers;

use App\Models\Biscuit;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function create()
    {
        $biscuits = Biscuit::all();

        return view('commande', compact('biscuits'));
    }

    // Enregistre la commande (POST)
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_biscuit' => 'nullable|string', 
            'prix'        => 'nullable|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'taille'      => 'nullable|string',
            'quantites'   => 'nullable|array',
            'email'       => 'nullable|email',
            'nom'         => 'nullable|string',
        ]);

        $commande = new Commande();
        $commande->client_nom  = $request->input('nom', '');
        $commande->client_email = $request->input('email', '');
        $commande->details_json = json_encode([
            'taille'    => $request->input('taille', null),
            'quantites' => $request->input('quantites', []),
        ]);
        $commande->save();

        return redirect()
            ->route('commandes.create')
            . '?ok=1';
    }
}
