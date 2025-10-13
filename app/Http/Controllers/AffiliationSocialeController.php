<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AffiliationSociale;
use App\Models\Contrat;
use App\Services\NotificationService;


class AffiliationSocialeController extends Controller
{
    // 1️⃣ Lister toutes les affiliations
    public function index()
    {
        $affiliations = AffiliationSociale::with(['contrat.candidature.candidat','contrat.candidature.annonce'])
            ->orderByDesc('date_affiliation')
            ->get();

        return view('rh.affiliations.index', compact('affiliations'));
    }

    // 2️⃣ Formulaire de création
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'contrat_id' => 'required|integer|exists:contrats,id',
                'organisme' => 'required|in:CNAPS,OSTIE,AMIT',
                'numero_affiliation' => 'required|string|max:100',
                'taux_cotisation' => 'numeric|min:0.5|max:5',
            ]);

            $contrat = Contrat::with('candidature.candidat')->findOrFail($request->contrat_id);
            $salaire = $contrat->salaire;
            $taux = $request->taux_cotisation ?? 1.0;

            $cotisation = round(($salaire * $taux) / 100, 2);

            $affiliation = AffiliationSociale::create([
                'contrat_id' => $contrat->id,
                'organisme' => $request->organisme,
                'numero_affiliation' => $request->numero_affiliation,
                'taux_cotisation' => $taux,
                'date_affiliation' => now()
            ]);

            // 🔔 Notification au candidat
            NotificationService::send(
                'affiliation',
                'candidat',
                $contrat->candidature->candidat_id,
                [
                    'message' => "Votre affiliation à {$affiliation->organisme} a été enregistrée avec succès.",
                    'numero' => $affiliation->numero_affiliation
                ]
            );

            // 🔔 Notification RH (optionnelle)
            NotificationService::send(
                'affiliation',
                'rh',
                0,
                [
                    'message' => "Affiliation de {$contrat->candidature->candidat->nom} enregistrée pour {$affiliation->organisme}."
                ]
            );

            return redirect()->route('affiliations.index')
                ->with('success', "Affiliation enregistrée ({$request->organisme}) — Cotisation: {$cotisation} Ar");
        }

        $contratsActifs = Contrat::with('candidature.candidat','candidature.annonce')
            ->where('statut', 'actif')
            ->get();

        return view('rh.affiliations.create', compact('contratsActifs'));
    }
}
