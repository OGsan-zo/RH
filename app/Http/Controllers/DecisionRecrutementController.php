<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\EvaluationEntretien;
use App\Models\ResultatTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DecisionRecrutementController extends Controller
{
    // 1️⃣ Voir profil complet du candidat
    public function show($candidatureId)
    {
        $candidature = Candidature::with(['candidat', 'annonce'])->findOrFail($candidatureId);
        $resultatTest = ResultatTest::where('candidature_id', $candidatureId)->first();
        $evaluation = EvaluationEntretien::whereHas('entretien', function($q) use ($candidatureId) {
            $q->where('candidature_id', $candidatureId);
        })->first();

        return view('rh.decisions.show', compact('candidature', 'resultatTest', 'evaluation'));
    }

    // 2️⃣ Accepter ou refuser un candidat
    public function update($candidatureId, $decision)
    {
        $candidature = Candidature::findOrFail($candidatureId);

        if ($decision === 'accepter') {
            $candidature->update(['statut' => 'retenu']);
            $message = 'Candidat accepté. Passera à l’étape du contrat.';
        } elseif ($decision === 'refuser') {
            $candidature->update(['statut' => 'refuse']);
            $message = 'Candidat refusé.';
        } else {
            abort(400, 'Décision invalide.');
        }

        // Simulation de notification — plus tard via table ou mail
        \Log::info("Notification envoyée à {$candidature->candidat->email} : {$message}");

        return redirect()->route('evaluations.resultats')->with('success', $message);
    }
}
