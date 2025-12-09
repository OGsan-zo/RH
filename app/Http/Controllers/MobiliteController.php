<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobilite;
use App\Models\Employe;
use App\Models\Poste;
use App\Models\Departement;
use App\Models\EnumTypeMobilite;
use App\Models\EnumStatutMobilite;

class MobiliteController extends Controller
{
    public function index()
    {
        $mobilites = Mobilite::with([
            'employe.candidat',
            'ancienDepartement',
            'nouveauDepartement',
            'ancienPoste',
            'nouveauPoste',
            'typeMobilite',
            'statut'
        ])->orderBy('date_demande', 'desc')->get();
        return view('rh.mobilites.index', compact('mobilites'));
    }

    public function create()
    {
        $employes = Employe::with('candidat')->get();
        $postes = Poste::all();
        $departements = Departement::all();
        $types = EnumTypeMobilite::all();
        $statuts = EnumStatutMobilite::all();
        return view('rh.mobilites.create', compact('employes', 'postes', 'departements', 'types', 'statuts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'ancien_departement_id' => 'nullable|exists:departements,id',
            'nouveau_departement_id' => 'nullable|exists:departements,id',
            'ancien_poste_id' => 'nullable|exists:postes,id',
            'nouveau_poste_id' => 'nullable|exists:postes,id',
            'date_demande' => 'required|date',
            'date_approbation' => 'nullable|date',
            'date_effet' => 'required|date|after_or_equal:date_demande',
            'type_mobilite_id' => 'required|exists:enum_types_mobilites,id',
            'motif' => 'nullable|string',
            'statut_id' => 'nullable|exists:enum_statuts_mobilites,id'
        ]);

        Mobilite::create($validated);
        return redirect()->route('mobilites.index')->with('success', 'Mobilité créée avec succès');
    }

    public function show($id)
    {
        $mobilite = Mobilite::with([
            'employe.candidat',
            'ancienDepartement',
            'nouveauDepartement',
            'ancienPoste',
            'nouveauPoste',
            'typeMobilite',
            'statut'
        ])->findOrFail($id);
        return view('rh.mobilites.show', compact('mobilite'));
    }

    public function edit($id)
    {
        $mobilite = Mobilite::findOrFail($id);
        $employes = Employe::with('candidat')->get();
        $postes = Poste::all();
        $departements = Departement::all();
        $types = EnumTypeMobilite::all();
        $statuts = EnumStatutMobilite::all();
        return view('rh.mobilites.edit', compact('mobilite', 'employes', 'postes', 'departements', 'types', 'statuts'));
    }

    public function update(Request $request, $id)
    {
        $mobilite = Mobilite::findOrFail($id);
        
        $validated = $request->validate([
            'ancien_departement_id' => 'nullable|exists:departements,id',
            'nouveau_departement_id' => 'nullable|exists:departements,id',
            'ancien_poste_id' => 'nullable|exists:postes,id',
            'nouveau_poste_id' => 'nullable|exists:postes,id',
            'date_demande' => 'required|date',
            'date_approbation' => 'nullable|date',
            'date_effet' => 'required|date|after_or_equal:date_demande',
            'type_mobilite_id' => 'required|exists:enum_types_mobilites,id',
            'motif' => 'nullable|string',
            'statut_id' => 'nullable|exists:enum_statuts_mobilites,id'
        ]);

        $mobilite->update($validated);
        return redirect()->route('mobilites.index')->with('success', 'Mobilité mise à jour');
    }

    public function destroy($id)
    {
        Mobilite::findOrFail($id)->delete();
        return redirect()->route('mobilites.index')->with('success', 'Mobilité supprimée');
    }
}
