<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\EvaluationEntretien;
use App\Models\ResultatTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;

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
        $message = '';


        if ($decision === 'accepter') {
            $candidature->update(['statut' => 'retenu']);

            // 🔔 Notification candidat retenu
            NotificationService::send(
                'decision',
                'candidat',
                $candidature->candidat_id,
                [
                    'message' => "Félicitations ! Votre candidature pour le poste '{$candidature->annonce->titre}' a été retenue."
                ]
            );
            $message = "Félicitations ! Votre candidature pour le poste '{$candidature->annonce->titre}' a été retenue.";
                
        } elseif ($decision === 'refuser') {
            $candidature->update(['statut' => 'refuse']);

            // 🔔 Notification candidat refusé
            NotificationService::send(
                'decision',
                'candidat',
                $candidature->candidat_id,
                [
                    'message' => "Merci pour votre intérêt. Votre candidature pour '{$candidature->annonce->titre}' n’a pas été retenue."
                ]
            );
            $message = "Merci pour votre intérêt. Votre candidature pour '{$candidature->annonce->titre}' n’a pas été retenue.";    
        }

        else {
            abort(400, 'Décision invalide.');
        }

        // Simulation de notification — plus tard via table ou mail
        \Log::info("Notification envoyée à {$candidature->candidat->email} : {$message}");

        return redirect()->route('evaluations.resultats')->with('success', $message);
    }
}
