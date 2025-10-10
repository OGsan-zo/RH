<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Departement;

class AnnonceController extends Controller
{
    // Lister toutes les annonces
    public function index()
    {
        $annonces = Annonce::with('departement')->orderBy('id', 'desc')->get();
        return view('rh.annonces.index', compact('annonces'));
    }

    // Formulaire de création
    public function create()
    {
        $departements = Departement::all();
        return view('rh.annonces.create', compact('departements'));
    }

    // Enregistrer une annonce
    public function store(Request $request)
    {
        $request->validate([
            'departement_id' => 'required|integer|exists:departements,id',
            'titre' => 'required|string|max:150',
            'description' => 'required|string',
            'competences_requises' => 'nullable|string',
            'niveau_requis' => 'nullable|string|max:100',
            'date_limite' => 'nullable|date'
        ]);

        Annonce::create([
            'departement_id' => $request->departement_id,
            'titre' => $request->titre,
            'description' => $request->description,
            'competences_requises' => $request->competences_requises,
            'niveau_requis' => $request->niveau_requis,
            'date_limite' => $request->date_limite,
            'statut' => 'ouverte',
        ]);

        return redirect()->route('annonces.index')->with('success', 'Annonce créée avec succès.');
    }

    // Formulaire de modification
    public function edit($id)
    {
        $annonce = Annonce::findOrFail($id);
        $departements = Departement::all();
        return view('rh.annonces.edit', compact('annonce', 'departements'));
    }

    // Mise à jour
    public function update(Request $request, $id)
    {
        $request->validate([
            'departement_id' => 'required|integer|exists:departements,id',
            'titre' => 'required|string|max:150',
            'description' => 'required|string',
            'competences_requises' => 'nullable|string',
            'niveau_requis' => 'nullable|string|max:100',
            'date_limite' => 'nullable|date'
        ]);

        $annonce = Annonce::findOrFail($id);
        $annonce->update($request->all());

        return redirect()->route('annonces.index')->with('success', 'Annonce mise à jour avec succès.');
    }

    // Supprimer
    public function destroy($id)
    {
        Annonce::destroy($id);
        return redirect()->route('annonces.index')->with('success', 'Annonce supprimée avec succès.');
    }

    // Fermer une annonce
    public function close($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->update(['statut' => 'fermée']);
        return redirect()->route('annonces.index')->with('success', 'Annonce fermée avec succès.');
    }
}
