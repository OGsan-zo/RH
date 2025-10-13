<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidature;
use App\Models\Entretien;
use App\Services\NotificationService;
use App\Models\User;

class EntretienController extends Controller
{
    // 1️⃣ Liste des candidats éligibles à l’entretien (note ≥ seuil)
    public function index()
    {
        // Score max global
        $seuil = Candidature::max('score_global');

        $candidatsEligibles = Candidature::with(['candidat', 'annonce'])
            ->where('score_global', '>=', $seuil)
            ->get();

        $entretiens = Entretien::with(['candidature.candidat', 'candidature.annonce'])->get();

        return view('rh.entretiens.index', compact('candidatsEligibles', 'entretiens', 'seuil'));
    }

    // 2️⃣ Planifier un entretien
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'candidature_id' => 'required|integer',
                'date_entretien' => 'required|date',
                'duree' => 'required|integer|min:15',
                'lieu' => 'required|string|max:150',
            ]);

            $entretien = Entretien::create([
                'candidature_id' => $request->candidature_id,
                'date_entretien' => $request->date_entretien,
                'duree' => $request->duree,
                'lieu' => $request->lieu,
                'rh_id' => session('user_id'),
                'statut' => 'planifie'
            ]);

            $cand = $entretien->candidature->candidat;

            // 🔔 Notification automatique
            NotificationService::send(
                'entretien',
                'candidat',
                $cand->id,
                [
                    'message' => "Un entretien est prévu le {$entretien->date_entretien} pour le poste '{$entretien->candidature->annonce->titre}'.",
                    'lieu' => $entretien->lieu
                ]
            );
      

            return redirect()->route('entretiens.index')->with('success', 'Entretien planifié avec succès.');
        }

        $candidatures = Candidature::with('candidat', 'annonce')
            ->where('score_global', '>', 0)
            ->get();

        return view('rh.entretiens.create', compact('candidatures'));
    }

    // 3️⃣ Modifier / supprimer un entretien
    public function delete($id)
    {
        $entretien = Entretien::findOrFail($id);
        $entretien->delete();
        return redirect()->back()->with('success', 'Entretien supprimé.');
    }

    // 4️⃣ Afficher le calendrier global
    public function calendrier()
    {
        $seuil = \App\Models\Candidature::max('score_global');

        $candidaturesEligibles = \App\Models\Candidature::with(['candidat','annonce'])
            ->where('score_global', '>=', $seuil)
            ->get();

        $entretiens = \App\Models\Entretien::with(['candidature.candidat','candidature.annonce'])->get();

        return view('rh.entretiens.calendrier', compact('entretiens', 'candidaturesEligibles', 'seuil'));
    }

}
