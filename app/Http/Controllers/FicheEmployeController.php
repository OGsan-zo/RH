<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FicheEmploye;
use App\Models\Employe;
use App\Models\Poste;
use App\Models\EnumSituationMatrimoniale;

class FicheEmployeController extends Controller
{
    public function index()
    {
        $fiches = FicheEmploye::with(['employe.candidat', 'poste', 'situationMatrimoniale'])->get();
        return view('rh.fiches-employes.index', compact('fiches'));
    }

    public function create()
    {
        $employes = Employe::with('candidat')->get();
        $postes = Poste::all();
        $situations = EnumSituationMatrimoniale::all();
        return view('rh.fiches-employes.create', compact('employes', 'postes', 'situations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id|unique:fiches_employes',
            'cin' => 'nullable|string|unique:fiches_employes',
            'lieu_naissance' => 'nullable|string',
            'nationalite' => 'nullable|string',
            'situation_matrimoniale_id' => 'nullable|exists:enum_situations_matrimoniales,id',
            'nombre_enfants' => 'nullable|integer|min:0',
            'telephone' => 'nullable|string',
            'telephone_secondaire' => 'nullable|string',
            'adresse_personnelle' => 'nullable|string',
            'ville' => 'nullable|string',
            'code_postal' => 'nullable|string',
            'poste_id' => 'nullable|exists:postes,id',
            'photo_path' => 'nullable|string',
            'iban' => 'nullable|string',
            'bic' => 'nullable|string',
            'titulaire_compte' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'date_embauche' => 'required|date',
            'date_fin_prevue' => 'nullable|date'
        ]);

        FicheEmploye::create($validated);
        return redirect()->route('fiches-employes.index')->with('success', 'Fiche employé créée avec succès');
    }

    public function show($id)
    {
        $fiche = FicheEmploye::with(['employe.candidat', 'poste', 'situationMatrimoniale'])->findOrFail($id);
        return view('rh.fiches-employes.show', compact('fiche'));
    }

    public function edit($id)
    {
        $fiche = FicheEmploye::findOrFail($id);
        $employes = Employe::with('candidat')->get();
        $postes = Poste::all();
        $situations = EnumSituationMatrimoniale::all();
        return view('rh.fiches-employes.edit', compact('fiche', 'employes', 'postes', 'situations'));
    }

    public function update(Request $request, $id)
    {
        $fiche = FicheEmploye::findOrFail($id);
        
        $validated = $request->validate([
            'cin' => 'nullable|string|unique:fiches_employes,cin,' . $id,
            'lieu_naissance' => 'nullable|string',
            'nationalite' => 'nullable|string',
            'situation_matrimoniale_id' => 'nullable|exists:enum_situations_matrimoniales,id',
            'nombre_enfants' => 'nullable|integer|min:0',
            'telephone' => 'nullable|string',
            'telephone_secondaire' => 'nullable|string',
            'adresse_personnelle' => 'nullable|string',
            'ville' => 'nullable|string',
            'code_postal' => 'nullable|string',
            'poste_id' => 'nullable|exists:postes,id',
            'photo_path' => 'nullable|string',
            'iban' => 'nullable|string',
            'bic' => 'nullable|string',
            'titulaire_compte' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'date_embauche' => 'required|date',
            'date_fin_prevue' => 'nullable|date'
        ]);

        $fiche->update($validated);
        return redirect()->route('fiches-employes.index')->with('success', 'Fiche employé mise à jour');
    }

    public function destroy($id)
    {
        FicheEmploye::findOrFail($id)->delete();
        return redirect()->route('fiches-employes.index')->with('success', 'Fiche employé supprimée');
    }
}
