<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Annonce;
use App\Models\Question;
use App\Models\Reponse;
use App\Services\GeminiService;

class TestController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    // Formulaire de sélection d'annonce
    public function create()
    {
        $annonces = Annonce::where('statut', 'ouverte')->get();
        return view('rh.tests.create', compact('annonces'));
    }

    // Génération automatique du test complet
    public function store(Request $request)
    {
        $request->validate([
            'annonce_id' => 'required|integer|exists:annonces,id',
            'nombre_questions' => 'required|integer|min:1|max:20',
            'nombre_reponses' => 'required|in:3,4'
        ]);

        $annonce = Annonce::findOrFail($request->annonce_id);

        $data = $this->gemini->genererTestComplet(
            $annonce->titre,
            $annonce->description,
            $request->nombre_questions,
            $request->nombre_reponses
        );

        if (isset($data['error'])) {
            return redirect()->back()->with('error', 'Erreur Gemini : '.$data['message']);
        }

        // Création du test
        $test = Test::create([
            'annonce_id' => $annonce->id,
            'titre' => $data['titre'] ?? "Test pour {$annonce->titre}",
            'description' => $data['description'] ?? "Test généré automatiquement pour {$annonce->titre}",
            'duree' => 20
        ]);

        // Insertion des questions et réponses
        foreach ($data['questions'] ?? [] as $q) {
            $question = Question::create([
                'test_id' => $test->id,
                'intitule' => $q['question'],
                'points' => 1
            ]);

            foreach ($q['reponses'] as $r) {
                Reponse::create([
                    'question_id' => $question->id,
                    'texte' => $r['texte'],
                    'est_correcte' => $r['est_correcte']
                ]);
            }
        }

        return redirect()->route('tests.view', ['annonce_id' => $annonce->id])
                         ->with('success', 'Test généré avec succès.');
    }

    // Visualisation du test (questions + bonnes réponses)
    public function view(Request $request)
    {
        $annonces = Annonce::all();
        $annonceId = $request->get('annonce_id');
        $test = null;

        if ($annonceId) {
            $test = Test::where('annonce_id', $annonceId)
                        ->with(['questions.reponses'])
                        ->first();
        }

        return view('rh.tests.view', compact('annonces', 'test', 'annonceId'));
    }

        // Supprimer un test QCM et ses questions/réponses
    public function destroy($id)
    {
        $test = Test::with('questions.reponses')->find($id);

        if (!$test) {
            return redirect()->back()->with('error', 'Test introuvable.');
        }

        // Suppression manuelle des réponses et questions
        foreach ($test->questions as $question) {
            $question->reponses()->delete();
        }
        $test->questions()->delete();

        // Suppression du test
        $test->delete();

        return redirect()->route('tests.view')->with('success', 'Test supprimé avec succès.');
    }

}
