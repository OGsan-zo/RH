<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Candidat;
use App\Models\Candidature;
use App\Services\CvParserService;
use App\Services\NotificationService;
use App\Services\GeminiService;


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

        // Récupération de l'annonce
        $annonce = Annonce::findOrFail($id);

        // Extraction de compétences et évaluation du CV
        $competences = '';
        $noteCv = null;
        
        // Le CV est stocké dans storage/app/public/
        $cvFullPath = storage_path('app/public/' . $candidat->cv_path);
        
        if ($candidat->cv_path && file_exists($cvFullPath)) {
            // Extraire le texte du PDF/DOC avec le parser
            $contenuTexte = $this->parser->extraireTexteDepuisFichier($cvFullPath);
            
            // Si l'extraction a réussi
            if (!empty($contenuTexte)) {
                $geminiService = app(GeminiService::class);
                
                // Extraction des compétences
                $competences = $geminiService->extraireCompetencesDepuisCV($contenuTexte);
                $candidat->update(['competences' => $competences]);
                
                // Évaluation de l'adéquation CV/Poste par IA
                $noteCv = $geminiService->evaluerCVPourPoste(
                    $contenuTexte,
                    $annonce->competences_requises ?? '',
                    $annonce->niveau_requis ?? '',
                    $annonce->description ?? ''
                );
            } else {
                // Si l'extraction échoue, mettre une note par défaut
                \Log::warning("Impossible d'extraire le texte du CV: " . $cvFullPath);
                $noteCv = 50.0; // Note neutre
            }
        }

        // Création de la candidature avec la note CV
        $candidature = Candidature::create([
            'candidat_id' => $candidat->id,
            'annonce_id' => $id,
            'statut' => 'en_attente',
            'note_cv' => $noteCv
        ]);

        // 🔔 Notifications automatiques
        NotificationService::send(
            'candidature',
            'rh',
            0,
            [
                'message' => "Nouvelle candidature pour le poste '{$candidature->annonce->titre}'.",
                'candidat' => "{$candidature->candidat->nom} {$candidature->candidat->prenom}"
            ]
        );

        NotificationService::send(
            'candidature',
            'candidat',
            $candidature->candidat_id,
            [
                'message' => "Votre candidature pour '{$candidature->annonce->titre}' a été enregistrée avec succès."
            ]
        );

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
