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
        $userRole = session('user_role');
        $userId = session('user_id');

        // Si RH : voir toutes les demandes
        // Si Manager : voir les demandes de son équipe
        if ($userRole === 'rh') {
            $demandes = DemandeCongé::with(['employe.candidat', 'typeCongé', 'validateur'])
                ->orderBy('date_creation', 'desc')
                ->paginate(15);
        } else {
            // Manager : voir les demandes de ses subalternes
            $manager = Employe::where('user_id', $userId)->first();
            $subalternesIds = $manager ? $manager->subalternes()->pluck('id')->toArray() : [];

            $demandes = DemandeCongé::with(['employe.candidat', 'typeCongé', 'validateur'])
                ->whereIn('employe_id', $subalternesIds)
                ->orderBy('date_creation', 'desc')
                ->paginate(15);
        }

        return view('conges.demandes.index', compact('demandes'));
    }

    public function create()
    {
        $employes = Employe::with('candidat')->get();
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
        // Vérifier les permissions
        if (!$this->peutValider($demandeCongé)) {
            return redirect()->back()->with('error', 'Vous n\'avez pas la permission de valider cette demande');
        }

        $validated = $request->validate([
            'commentaire_validation' => 'nullable|string'
        ]);

        $this->congéService->validerDemandeCongé(
            $demandeCongé,
            session('user_id'),
            true,
            $validated['commentaire_validation'] ?? null
        );

        return redirect()->route('demandes-conges.show', $demandeCongé->id)
            ->with('success', 'Demande de congé approuvée');
    }

    public function rejeter(Request $request, DemandeCongé $demandeCongé)
    {
        // Vérifier les permissions
        if (!$this->peutValider($demandeCongé)) {
            return redirect()->back()->with('error', 'Vous n\'avez pas la permission de valider cette demande');
        }

        $validated = $request->validate([
            'commentaire_validation' => 'required|string'
        ]);

        $this->congéService->validerDemandeCongé(
            $demandeCongé,
            session('user_id'),
            false,
            $validated['commentaire_validation']
        );

        return redirect()->route('demandes-conges.show', $demandeCongé->id)
            ->with('success', 'Demande de congé rejetée');
    }

    /**
     * Vérifier si l'utilisateur peut valider une demande
     * RH : peut valider toutes les demandes
     * Manager : peut valider les demandes de son équipe
     */
    private function peutValider(DemandeCongé $demandeCongé)
    {
        $userRole = session('user_role');
        $userId = session('user_id');

        // RH peut tout valider
        if ($userRole === 'rh') {
            return true;
        }

        // Manager ne peut valider que les demandes de son équipe
        if ($userRole === 'manager') {
            $manager = Employe::where('user_id', $userId)->first();
            if (!$manager) {
                return false;
            }

            // Vérifier que l'employé est un subordonné
            return $demandeCongé->employe->manager_id === $manager->id;
        }

        return false;
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
