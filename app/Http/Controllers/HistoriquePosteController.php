<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriquePoste;
use App\Models\Employe;
use App\Models\Poste;
use App\Models\Departement;
use App\Models\EnumTypeMouvement;

class HistoriquePosteController extends Controller
{
    public function index()
    {
        $historiques = HistoriquePoste::with(['employe.candidat', 'poste', 'departement', 'typeMouvement'])
            ->orderBy('date_debut', 'desc')
            ->get();
        return view('rh.historique-postes.index', compact('historiques'));
    }

    public function create()
    {
        $employes = Employe::with('candidat')->get();
        $postes = Poste::all();
        $departements = Departement::all();
        $types = EnumTypeMouvement::all();
        return view('rh.historique-postes.create', compact('employes', 'postes', 'departements', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'poste_id' => 'nullable|exists:postes,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
            'titre_poste' => 'nullable|string',
            'departement_id' => 'nullable|exists:departements,id',
            'salaire' => 'nullable|numeric|min:0',
            'type_mouvement_id' => 'required|exists:enum_types_mouvements,id'
        ]);

        HistoriquePoste::create($validated);
        return redirect()->route('historique-postes.index')->with('success', 'Historique créé avec succès');
    }

    public function show($id)
    {
        $historique = HistoriquePoste::with(['employe.candidat', 'poste', 'departement', 'typeMouvement'])->findOrFail($id);
        return view('rh.historique-postes.show', compact('historique'));
    }

    public function edit($id)
    {
        $historique = HistoriquePoste::findOrFail($id);
        $employes = Employe::with('candidat')->get();
        $postes = Poste::all();
        $departements = Departement::all();
        $types = EnumTypeMouvement::all();
        return view('rh.historique-postes.edit', compact('historique', 'employes', 'postes', 'departements', 'types'));
    }

    public function update(Request $request, $id)
    {
        $historique = HistoriquePoste::findOrFail($id);
        
        $validated = $request->validate([
            'poste_id' => 'nullable|exists:postes,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
            'titre_poste' => 'nullable|string',
            'departement_id' => 'nullable|exists:departements,id',
            'salaire' => 'nullable|numeric|min:0',
            'type_mouvement_id' => 'required|exists:enum_types_mouvements,id'
        ]);

        $historique->update($validated);
        return redirect()->route('historique-postes.index')->with('success', 'Historique mis à jour');
    }

    public function destroy($id)
    {
        HistoriquePoste::findOrFail($id)->delete();
        return redirect()->route('historique-postes.index')->with('success', 'Historique supprimé');
    }
}
