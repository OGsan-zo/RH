<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;

class DepartementController extends Controller
{
    // Lister tous les départements
    public function index()
    {
        $departements = Departement::orderBy('id', 'asc')->get();
        return view('rh.departements.index', compact('departements'));
    }

    // Formulaire de création
    public function create()
    {
        return view('rh.departements.create');
    }

    // Enregistrer un nouveau département
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:150'
        ]);

        Departement::create(['nom' => $request->nom]);

        return redirect()->route('departements.index')
            ->with('success', 'Département ajouté avec succès.');
    }

    // Formulaire d’édition
    public function edit($id)
    {
        $departement = Departement::findOrFail($id);
        return view('rh.departements.edit', compact('departement'));
    }

    // Mettre à jour un département
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:150'
        ]);

        $departement = Departement::findOrFail($id);
        $departement->update(['nom' => $request->nom]);

        return redirect()->route('departements.index')
            ->with('success', 'Département modifié avec succès.');
    }

    // Supprimer un département
    public function destroy($id)
    {
        Departement::destroy($id);
        return redirect()->route('departements.index')
            ->with('success', 'Département supprimé avec succès.');
    }
}
