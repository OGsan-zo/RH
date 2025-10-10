<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Candidat;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\ResultatTest;
use App\Models\Candidature;
use App\Models\CandidatReponse;
use Illuminate\Support\Facades\DB;

class TestEnLigneController extends Controller
{
    // Afficher le test
    public function show($testId)
    {
        $test = Test::with(['questions.reponses'])->findOrFail($testId);
        return view('candidat.qcm.passer', compact('test'));
    }

    // Soumettre les réponses
    public function submit(Request $request, $testId)
    {
        $test = Test::with('questions.reponses')->findOrFail($testId);
        $userId = session('user_id');
        $candidat = Candidat::where('user_id', $userId)->firstOrFail();

        $candidature = Candidature::where('candidat_id', $candidat->id)
            ->where('annonce_id', $test->annonce_id)
            ->firstOrFail();

        DB::beginTransaction();
        try {
            $total = $test->questions->count();
            $score = 0;

            $resultat = ResultatTest::create([
                'candidature_id' => $candidature->id,
                'test_id' => $test->id,
                'score' => 0
            ]);

            foreach ($test->questions as $question) {
                $reponseChoisie = $request->input('question_'.$question->id);
                $bonneReponse = $question->reponses->where('est_correcte', true)->first();
                $estCorrecte = ($bonneReponse && $bonneReponse->id == $reponseChoisie);

                if ($estCorrecte) {
                    $score++;
                }

                CandidatReponse::create([
                    'resultat_test_id' => $resultat->id,
                    'question_id' => $question->id,
                    'reponse_id' => $reponseChoisie,
                    'est_correcte' => $estCorrecte
                ]);
            }

            $pourcentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;
            $resultat->update(['score' => $pourcentage]);

            $candidature->update([
                'statut' => 'test_en_cours',
                'score_global' => $pourcentage
            ]);

            DB::commit();

            return view('candidat.qcm.resultat', compact('test', 'pourcentage'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la soumission : '.$e->getMessage());
        }
    }

    public function selectTest()
    {
        $userId = session('user_id');
        $candidat = \App\Models\Candidat::where('user_id', $userId)->first();

        if (!$candidat) {
            return redirect()->back()->with('error', 'Profil candidat introuvable.');
        }

        // récupérer les candidatures valides avec leurs annonces et tests
        $candidatures = \App\Models\Candidature::where('candidat_id', $candidat->id)
            ->where('statut', 'en_attente')
            ->with('annonce')
            ->get();

        return view('candidat.qcm.select', compact('candidatures'));
    }

}
