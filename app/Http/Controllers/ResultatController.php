<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\ResultatTest;

class ResultatController extends Controller
{
    // Voir les réponses d’un candidat
    public function details($candidatureId)
    {
        $candidature = Candidature::with(['candidat', 'annonce'])->findOrFail($candidatureId);

        $resultat = ResultatTest::where('candidature_id', $candidatureId)
            ->with(['reponsesCandidat.question.reponses'])
            ->first();

        return view('rh.resultats.details', compact('candidature', 'resultat'));
    }

    public function selectResult()
    {
        // Liste des candidats ayant passé un test
        $resultats = \App\Models\ResultatTest::with(['candidature.candidat', 'test'])
            ->orderByDesc('date_passage')
            ->get();

        return view('rh.resultats.select', compact('resultats'));
    }

    }
