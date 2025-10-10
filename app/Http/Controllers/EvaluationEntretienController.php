<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluationEntretien;
use App\Models\Entretien;
use App\Models\ResultatTest;
use App\Models\Candidature;

class EvaluationEntretienController extends Controller
{
    // 1️⃣ Liste des entretiens confirmés
    public function index()
    {
        $entretiensConfirmes = Entretien::with(['candidature.candidat', 'candidature.annonce'])
            ->where('statut', 'confirme')
            ->get();

        return view('rh.evaluations.index', compact('entretiensConfirmes'));
    }

    // 2️⃣ Page d'évaluation
    public function create($id)
    {
        $entretien = Entretien::with(['candidature.candidat', 'candidature.annonce'])->findOrFail($id);
        return view('rh.evaluations.create', compact('entretien'));
    }

    // 3️⃣ Enregistrement de l'évaluation
    public function store(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'remarques' => 'nullable|string'
        ]);

        $entretien = Entretien::with('candidature')->findOrFail($id);

        // Création de l'évaluation
        EvaluationEntretien::create([
            'entretien_id' => $entretien->id,
            'note' => $request->note,
            'remarques' => $request->remarques
        ]);

        // Score test
        $scoreTest = \App\Models\ResultatTest::where('candidature_id', $entretien->candidature_id)->value('score') ?? 0;

        // Calcul final : moyenne entre test et entretien (pondération simple)
        $scoreFinal = round(($scoreTest + (($request->note / 20) * 100)) / 2, 2);

        // Mise à jour de la candidature
        $entretien->candidature->update([
            'score_global' => $scoreFinal,
            'statut' => 'en_entretien'
        ]);

        // Marquer entretien comme évalué
        $entretien->update(['statut' => 'evalue']);

        return redirect()->route('evaluations.resultats')->with('success', 'Évaluation enregistrée et score global mis à jour.');
    }

    // 4️⃣ Voir résultats par poste
    public function resultats(Request $request)
    {
        $posteId = $request->input('annonce_id');
        $annonces = \App\Models\Annonce::all();

        $candidatures = [];
        if ($posteId) {
            $candidatures = Candidature::with(['candidat', 'annonce'])
                ->where('annonce_id', $posteId)
                ->where('statut', 'en_entretien')
                ->orderByDesc('score_global')
                ->get();
        }

        return view('rh.evaluations.resultats', compact('annonces', 'candidatures', 'posteId'));
    }
}
