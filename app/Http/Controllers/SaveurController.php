<?php

namespace App\Http\Controllers;

use App\Models\Saveur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaveurController extends Controller
{
    public function __construct()
    {
        // Restreindre toutes les méthodes aux administrateurs uniquement
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || (!Auth::user()->is_admin && Auth::user()->role !== 'ADMIN')) {
                abort(403, 'Accès refusé. Cette page est réservée aux administrateurs.');
            }
            return $next($request);
        });
    }

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
            'emoji' => 'nullable|string|max:10',
        ]);

        Saveur::create($data);
        return redirect()->route('saveurs.index')->with('success', 'Saveur créée avec succès !');
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
            'emoji' => 'nullable|string|max:10',
        ]);

        $saveur->update($data);
        return redirect()->route('saveurs.index')->with('success', 'Saveur modifiée avec succès !');
    }

    public function destroy(Saveur $saveur)
    {
        $saveur->delete();
        return redirect()->route('saveurs.index')->with('success', 'Saveur supprimée.');
    }

    
}
