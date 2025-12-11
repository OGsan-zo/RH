<?php

namespace App\Http\Controllers;

use App\Models\DemandeCongé;
use App\Models\Employe;
use App\Models\TypeCongé;
use App\Services\CongéService;
use Illuminate\Http\Request;

class DemandeCongéController extends Controller
{
    protected $congéService;

    public function __construct(CongéService $congéService)
    {
        $this->congéService = $congéService;
    }

    public function index()
    {
        $demandes = DemandeCongé::with(['employe', 'typeCongé', 'validateur'])
            ->orderBy('date_creation', 'desc')
            ->paginate(15);

        return view('conges.demandes.index', compact('demandes'));
    }

    public function create()
    {
        $employes = Employe::all();
        $typesConges = TypeCongé::where('est_actif', true)->get();

        return view('conges.demandes.create', compact('employes', 'typesConges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'type_conge_id' => 'required|exists:types_conges,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'nullable|string',
            'certificat_medical' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $certificatPath = null;
        if ($request->hasFile('certificat_medical')) {
            $certificatPath = $request->file('certificat_medical')->store('certificats_medicaux', 'public');
        }

        $validated['certificat_medical_path'] = $certificatPath;

        $demande = $this->congéService->creerDemandeCongé($validated);

        return redirect()->route('demandes-conges.show', $demande->id)
            ->with('success', 'Demande de congé créée avec succès');
    }

    public function show(DemandeCongé $demandeCongé)
    {
        $demandeCongé->load(['employe', 'typeCongé', 'validateur']);

        return view('conges.demandes.show', compact('demandeCongé'));
    }

    public function edit(DemandeCongé $demandeCongé)
    {
        if (!$demandeCongé->estEnAttente()) {
            return redirect()->route('demandes-conges.show', $demandeCongé->id)
                ->with('error', 'Impossible de modifier une demande validée');
        }

        $employes = Employe::all();
        $typesConges = TypeCongé::where('est_actif', true)->get();

        return view('conges.demandes.edit', compact('demandeCongé', 'employes', 'typesConges'));
    }

    public function update(Request $request, DemandeCongé $demandeCongé)
    {
        if (!$demandeCongé->estEnAttente()) {
            return redirect()->route('demandes-conges.show', $demandeCongé->id)
                ->with('error', 'Impossible de modifier une demande validée');
        }

        $validated = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'nullable|string',
            'certificat_medical' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('certificat_medical')) {
            $certificatPath = $request->file('certificat_medical')->store('certificats_medicaux', 'public');
            $validated['certificat_medical_path'] = $certificatPath;
        }

        $demandeCongé->update($validated);

        return redirect()->route('demandes-conges.show', $demandeCongé->id)
            ->with('success', 'Demande de congé mise à jour');
    }

    public function approuver(Request $request, DemandeCongé $demandeCongé)
    {
        $validated = $request->validate([
            'commentaire_validation' => 'nullable|string'
        ]);

        $this->congéService->validerDemandeCongé(
            $demandeCongé,
            auth()->id(),
            true,
            $validated['commentaire_validation'] ?? null
        );

        return redirect()->route('demandes-conges.show', $demandeCongé->id)
            ->with('success', 'Demande de congé approuvée');
    }

    public function rejeter(Request $request, DemandeCongé $demandeCongé)
    {
        $validated = $request->validate([
            'commentaire_validation' => 'required|string'
        ]);

        $this->congéService->validerDemandeCongé(
            $demandeCongé,
            auth()->id(),
            false,
            $validated['commentaire_validation']
        );

        return redirect()->route('demandes-conges.show', $demandeCongé->id)
            ->with('success', 'Demande de congé rejetée');
    }

    public function destroy(DemandeCongé $demandeCongé)
    {
        if (!$demandeCongé->estEnAttente()) {
            return redirect()->route('demandes-conges.index')
                ->with('error', 'Impossible de supprimer une demande validée');
        }

        $demandeCongé->delete();

        return redirect()->route('demandes-conges.index')
            ->with('success', 'Demande de congé supprimée');
    }
}
