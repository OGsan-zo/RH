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

    public function edit(Request $request, $id)
    {
        $contrat = \App\Models\Contrat::with('candidature.candidat','candidature.annonce')->findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'type_contrat' => 'required|in:essai,CDD,CDI',
                'date_fin' => 'nullable|date',
                'salaire'  => 'required|numeric|min:0',
            ]);

            // Validation métier
            if ($request->type_contrat === 'essai') {
                if ($contrat->renouvellement >= 1) {
                    return back()->with('error', 'Le contrat d’essai a déjà été renouvelé une fois.');
                }
                if ($request->filled('date_fin')) {
                    $debut = \Carbon\Carbon::parse($contrat->date_debut);
                    $fin   = \Carbon\Carbon::parse($request->date_fin);
                    if ($debut->diffInMonths($fin) > 6) {
                        return back()->with('error', 'Un contrat d’essai ne peut dépasser 6 mois au total.');
                    }
                }
            }

            // Si on change le type, le renouvellement repasse à zéro
            $renouvellement = $contrat->type_contrat !== $request->type_contrat
                ? 0
                : $contrat->renouvellement + 1;

            $contrat->update([
                'type_contrat' => $request->type_contrat,
                'date_fin'     => $request->date_fin,
                'salaire'      => $request->salaire,
                'renouvellement'=> $renouvellement,
            ]);

            return redirect()->route('contrats.index')
                ->with('success', 'Contrat renouvelé / modifié avec succès.');
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
