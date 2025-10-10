<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Candidat;
use App\Models\Candidature;
use App\Services\CvParserService;

class CandidatureController extends Controller
{
    protected $parser;

    public function __construct(CvParserService $parser)
    {
        $this->parser = $parser;
    }

    // 1️⃣ Liste des annonces disponibles
    public function index()
    {
        $annonces = Annonce::where('statut', 'ouverte')->get();
        return view('candidat.annonces', compact('annonces'));
    }

    // 2️⃣ Détails d’une annonce
    public function show($id)
    {
        $annonce = Annonce::findOrFail($id);
        return view('candidat.details', compact('annonce'));
    }

    // 3️⃣ Postuler à une annonce
    public function postuler($id)
    {
        $userId = session('user_id');
        $candidat = Candidat::where('user_id', $userId)->first();

        if (!$candidat) {
            return redirect()->back()->with('error', 'Profil candidat introuvable.');
        }

        // Vérifier si une candidature est déjà active
        $active = Candidature::where('candidat_id', $candidat->id)
                             ->whereIn('statut', ['en_attente', 'test_en_cours', 'en_entretien'])
                             ->exists();

        if ($active) {
            return redirect()->back()->with('error', 'Vous avez déjà une candidature active.');
        }

        // Extraction de compétences à partir du CV
        $competences = '';
        if ($candidat->cv_path && file_exists(public_path($candidat->cv_path))) {
            $contenu = file_get_contents(public_path($candidat->cv_path));
            $competences = app(\App\Services\GeminiService::class)->extraireCompetencesDepuisCV($contenu);
            $candidat->update(['competences' => $competences]);
        }

        // Création de la candidature
        Candidature::create([
            'candidat_id' => $candidat->id,
            'annonce_id' => $id,
            'statut' => 'en_attente'
        ]);

        return redirect()->route('candidatures.suivi')
                         ->with('success', 'Votre candidature a été soumise avec succès.');
    }

    // 4️⃣ Suivi des candidatures
    public function suivi()
    {
        $userId = session('user_id');
        $candidat = Candidat::where('user_id', $userId)->first();
        $candidatures = $candidat ? $candidat->candidatures()->with('annonce')->get() : [];

        return view('candidat.suivi', compact('candidatures'));
    }
}
