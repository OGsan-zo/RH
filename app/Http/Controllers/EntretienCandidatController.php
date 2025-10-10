<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entretien;
use App\Models\Candidat;

class EntretienCandidatController extends Controller
{
    // 5️⃣ Voir les notifications d’entretien
    public function index()
    {
        $userId = session('user_id');
        $candidat = Candidat::where('user_id', $userId)->first();
        $entretiens = Entretien::whereHas('candidature', function($q) use ($candidat) {
            $q->where('candidat_id', $candidat->id);
        })->get();

        return view('candidat.entretiens.notifications', compact('entretiens'));
    }

    // 6️⃣ Confirmer ou refuser
    public function reponse($id, $decision)
    {
        $entretien = Entretien::findOrFail($id);

        if ($decision === 'confirmer') {
            $entretien->update(['statut' => 'confirme']);
        } elseif ($decision === 'refuser') {
            $entretien->update(['statut' => 'refuse']);
        }

        return redirect()->back()->with('success', 'Votre réponse a été envoyée.');
    }
}
