<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Candidature;
use Carbon\Carbon;

class ContratController extends Controller
{
    // 1️⃣ Liste des candidats et contrats existants
    public function index()
    {
        $retenus = Candidature::with(['candidat', 'annonce'])
            ->where('statut', 'retenu')
            ->get();

        $contrats = Contrat::with(['candidature.candidat', 'candidature.annonce'])
            ->orderByDesc('date_debut')
            ->get();

        return view('rh.contrats.index', compact('retenus', 'contrats'));
    }

    // 2️⃣ Création de contrat
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'candidature_id' => 'required|integer|exists:candidatures,id',
                'type_contrat' => 'required|in:essai,CDD,CDI',
                'statut' => 'required|in:actif,renouvelé,fin_essai,termine,expiré,clos,suspendu',
                'date_debut' => 'required|date',
                'date_fin' => 'nullable|date|after:date_debut',
                'salaire' => 'required|numeric|min:0',
            ]);

            // Validation règle métier : essai ≤ 6 mois
            if ($request->type_contrat === 'essai' && $request->filled('date_fin')) {
                $debut = Carbon::parse($request->date_debut);
                $fin = Carbon::parse($request->date_fin);
                if ($debut->diffInMonths($fin) > 6) {
                    return back()->with('error', 'Un contrat d’essai ne peut dépasser 6 mois.');
                }
            }

            Contrat::create([
                'candidature_id' => $request->candidature_id,
                'type_contrat'   => $request->type_contrat,
                'statut'         => $request->statut,
                'date_debut'     => $request->date_debut,
                'date_fin'       => $request->date_fin,
                'salaire'        => $request->salaire,
                'renouvellement' => 0
            ]);

            return redirect()->route('contrats.index')->with('success', 'Contrat créé avec succès.');
        }

        $candidats = Candidature::with('candidat','annonce')
            ->where('statut','retenu')
            ->doesntHave('contrat')
            ->get();

        return view('rh.contrats.create', compact('candidats'));
    }

    // 3️⃣ Modification / renouvellement de contrat
    public function edit(Request $request, $id)
    {
        $contrat = Contrat::with('candidature.candidat','candidature.annonce')->findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'type_contrat' => 'required|in:essai,CDD,CDI',
                'statut' => 'required|in:actif,renouvelé,fin_essai,termine,expiré,clos,suspendu',
                'date_fin' => 'nullable|date|after_or_equal:date_debut',
                'salaire' => 'required|numeric|min:0',
            ]);

            // Règle métier pour contrat d’essai
            if ($request->type_contrat === 'essai') {
                if ($contrat->renouvellement >= 1 && $contrat->type_contrat === 'essai') {
                    return back()->with('error', 'Le contrat d’essai a déjà été renouvelé une fois.');
                }

                if ($request->filled('date_fin')) {
                    $debut = Carbon::parse($contrat->date_debut);
                    $fin = Carbon::parse($request->date_fin);
                    if ($debut->diffInMonths($fin) > 6) {
                        return back()->with('error', 'Un contrat d’essai ne peut dépasser 6 mois au total.');
                    }
                }
            }

            // Gestion du compteur de renouvellement
            $renouvellement = ($contrat->type_contrat === $request->type_contrat)
                ? $contrat->renouvellement + 1
                : 0;

            $contrat->update([
                'type_contrat'   => $request->type_contrat,
                'statut'         => $request->statut,
                'date_fin'       => $request->date_fin,
                'salaire'        => $request->salaire,
                'renouvellement' => $renouvellement
            ]);

            return redirect()->route('contrats.index')->with('success', 'Contrat mis à jour avec succès.');
        }

        return view('rh.contrats.edit', compact('contrat'));
    }

    // 4️⃣ Liste par statut
    public function status(Request $request)
    {
        $filtre = $request->input('statut', 'actif');

        // Mise à jour automatique des contrats expirés
        $now = Carbon::now();
        Contrat::where('date_fin', '<', $now)
            ->where('statut', 'actif')
            ->update(['statut' => 'expiré']);

        $contrats = Contrat::with(['candidature.candidat','candidature.annonce'])
            ->when($filtre, function($query) use ($filtre) {
                $query->where('statut', $filtre);
            })
            ->orderByDesc('date_debut')
            ->get();

        $statuts = ['actif', 'renouvelé', 'fin_essai', 'termine', 'expiré', 'clos', 'suspendu'];

        return view('rh.contrats.status', compact('contrats','filtre','statuts'));
    }
}
