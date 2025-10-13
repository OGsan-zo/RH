<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Candidat;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;


class ContratCandidatController extends Controller
{
    // 5️⃣ Détails contrat + notification
    public function details()
    {
        $userId = session('user_id');
        $candidat = Candidat::where('user_id', $userId)->first();
        $contrat = Contrat::whereHas('candidature', function($q) use ($candidat) {
            $q->where('candidat_id', $candidat->id);
        })->with('candidature.annonce')->first();

        return view('candidat.contrat.details', compact('contrat'));
    }

    // 7️⃣ Notification de fin d’essai
    public function notifierFinEssai($id)
    {
        $contrat = Contrat::findOrFail($id);
        $contrat->update(['statut' => 'fin_essai']);

        NotificationService::send(
            'contrat',
            'rh',
            0, // inbox RH globale
            [
                'message' => "Le candidat {$contrat->candidature->candidat->nom} {$contrat->candidature->candidat->prenom} a signalé la fin de son contrat d’essai.",
                'contrat_id' => $contrat->id
            ]
        );

        \Log::info("Notification RH : le candidat {$contrat->candidature->candidat->email} a signalé la fin de son contrat d’essai.");
        return back()->with('success', 'Notification envoyée au service RH.');
    }
}
