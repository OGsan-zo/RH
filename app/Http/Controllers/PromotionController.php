<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Employe;
use App\Models\Poste;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with(['employe.candidat', 'ancienPoste', 'nouveauPoste'])
            ->orderBy('date_promotion', 'desc')
            ->get();
        return view('rh.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $employes = Employe::with('candidat')->get();
        $postes = Poste::all();
        return view('rh.promotions.create', compact('employes', 'postes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'ancien_poste_id' => 'nullable|exists:postes,id',
            'nouveau_poste_id' => 'required|exists:postes,id',
            'ancien_salaire' => 'nullable|numeric|min:0',
            'nouveau_salaire' => 'required|numeric|min:0',
            'date_promotion' => 'required|date',
            'date_effet' => 'required|date|after_or_equal:date_promotion',
            'motif' => 'nullable|string',
            'decision_numero' => 'nullable|string|unique:promotions'
        ]);

        Promotion::create($validated);
        return redirect()->route('promotions.index')->with('success', 'Promotion créée avec succès');
    }

    public function show($id)
    {
        $promotion = Promotion::with(['employe.candidat', 'ancienPoste', 'nouveauPoste'])->findOrFail($id);
        return view('rh.promotions.show', compact('promotion'));
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        $employes = Employe::with('candidat')->get();
        $postes = Poste::all();
        return view('rh.promotions.edit', compact('promotion', 'employes', 'postes'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        
        $validated = $request->validate([
            'ancien_poste_id' => 'nullable|exists:postes,id',
            'nouveau_poste_id' => 'required|exists:postes,id',
            'ancien_salaire' => 'nullable|numeric|min:0',
            'nouveau_salaire' => 'required|numeric|min:0',
            'date_promotion' => 'required|date',
            'date_effet' => 'required|date|after_or_equal:date_promotion',
            'motif' => 'nullable|string',
            'decision_numero' => 'nullable|string|unique:promotions,decision_numero,' . $id
        ]);

        $promotion->update($validated);
        return redirect()->route('promotions.index')->with('success', 'Promotion mise à jour');
    }

    public function destroy($id)
    {
        Promotion::findOrFail($id)->delete();
        return redirect()->route('promotions.index')->with('success', 'Promotion supprimée');
    }
}
