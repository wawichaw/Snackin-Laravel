<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeCrudController extends Controller
{
    public function index()
    {
        $commandes = Commande::orderByDesc('id')->paginate(15);
        return view('commandes_admin.index', compact('commandes'));
    }

    public function create()
    {
        return view('commandes_admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'taille_boite' => 'required|integer|in:4,6,12',
            'nom_client'   => 'required|string|max:255',
            'email_client' => 'required|email|max:255',
            'total_prix'   => 'nullable|numeric',
            'details'      => 'nullable|array',
            'status'       => 'nullable|string|max:50',
        ]);

        Commande::create($data);
        return redirect()->route('commandes-admin.index')->with('success', 'Commande créée.');
    }

    public function show(Commande $commande)
    {
        return view('commandes_admin.show', compact('commande'));
    }

    public function edit(Commande $commande)
    {
        return view('commandes_admin.edit', compact('commande'));
    }

    public function update(Request $request, Commande $commande)
    {
        $data = $request->validate([
            'taille_boite' => 'required|integer|in:4,6,12',
            'nom_client'   => 'required|string|max:255',
            'email_client' => 'required|email|max:255',
            'total_prix'   => 'nullable|numeric',
            'details'      => 'nullable|array',
            'status'       => 'nullable|string|max:50',
        ]);

        $commande->update($data);
        return redirect()->route('commandes-admin.index')->with('success', 'Commande mise à jour.');
    }

    public function destroy(Commande $commande)
    {
        $commande->delete();
        return redirect()->route('commandes-admin.index')->with('success', 'Commande supprimée.');
    }
}
