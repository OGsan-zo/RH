<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Candidature;
use Carbon\Carbon;

class ContratController extends Controller
{
    // 1️⃣ Liste candidats retenus sans contrat
    public function index()
    {
        $retenus = Candidature::with(['candidat', 'annonce'])
            ->where('statut', 'retenu')
            ->get();

        $contrats = Contrat::with(['candidature.candidat', 'candidature.annonce'])->get();

        return view('rh.contrats.index', compact('retenus', 'contrats'));
    }

    // 2️⃣ Créer un contrat
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'candidature_id' => 'required|integer',
                'type_contrat' => 'required|in:essai,CDD,CDI',
                'date_debut' => 'required|date',
                'date_fin' => 'nullable|date|after:date_debut',
                'salaire' => 'required|numeric|min:0',
            ]);

            // Validation règle métier : essai ≤ 6 mois
            if ($request->type_contrat === 'essai') {
                $debut = Carbon::parse($request->date_debut);
                $fin = Carbon::parse($request->date_fin);
                if ($debut->diffInMonths($fin) > 6) {
                    return back()->with('error', 'Un contrat d’essai ne peut dépasser 6 mois.');
                }
            }

            Contrat::create($request->all());
            return redirect()->route('contrats.index')->with('success', 'Contrat créé avec succès.');
        }

        $candidats = Candidature::with('candidat','annonce')
            ->where('statut','retenu')
            ->doesntHave('contrat')
            ->get();

        return view('rh.contrats.create', compact('candidats'));
    }

    // 3️⃣ Modifier / renouveler
    public function edit(Request $request, $id)
    {
        $contrat = Contrat::with('candidature.candidat','candidature.annonce')->findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'date_fin' => 'nullable|date|after:date_debut',
                'salaire' => 'required|numeric|min:0',
            ]);

            // Gestion renouvellement unique
            if ($contrat->type_contrat === 'essai' && $contrat->renouvellement >= 1) {
                return back()->with('error', 'Ce contrat d’essai a déjà été renouvelé une fois.');
            }

            $contrat->update([
                'date_fin' => $request->date_fin,
                'salaire' => $request->salaire,
                'renouvellement' => $contrat->renouvellement + 1,
            ]);

            return redirect()->route('contrats.index')->with('success','Contrat mis à jour.');
        }

        return view('rh.contrats.edit', compact('contrat'));
    }

    // 4️⃣ Statuts des contrats
    public function status()
    {
        $actifs = Contrat::where('statut', 'actif')->get();
        $expires = Contrat::where('statut', 'expiré')->get();
        $clos = Contrat::where('statut', 'clos')->get();

        return view('rh.contrats.status', compact('actifs','expires','clos'));
    }
}
