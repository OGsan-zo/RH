<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Candidature;

class TriCandidatController extends Controller
{
    /**
     * Affiche le formulaire de sélection d'annonce
     */
    public function index()
    {
        $annonces = Annonce::all();
        return view('rh.tri-candidats.index', compact('annonces'));
    }

    /**
     * Affiche les candidats triés par score global pour une annonce donnée avec filtres
     * 
     * @param Request $request Requête HTTP contenant les filtres
     * @param int $annonceId ID de l'annonce sélectionnée
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $annonceId)
    {
        // Récupérer toutes les annonces pour le dropdown
        $annonces = Annonce::all();
        
        // Récupérer l'annonce sélectionnée avec son département
        $annonce = Annonce::with('departement')->findOrFail($annonceId);
        
        // Récupérer et valider les filtres
        $filters = $request->only(['search_nom', 'age_min', 'age_max', 'search_competences', 'filter_statut']);
        
        // Construction de la requête avec eager loading pour éviter N+1
        $query = Candidature::with(['candidat', 'annonce.departement'])
            ->where('annonce_id', $annonceId);
        
        // Application des filtres
        $query = $this->applyFilters($query, $filters);
        
        // Récupération des candidatures
        $candidatures = $query->get();
        
        // Enrichissement des données (scores, âge)
        $candidatures = $this->enrichCandidatures($candidatures);
        
        // Tri par score global décroissant
        $candidatures = $candidatures->sortByDesc('score_global');
        
        return view('rh.tri-candidats.index', compact('annonces', 'candidatures', 'annonce'));
    }
    
    /**
     * Applique les filtres de recherche sur la requête
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applyFilters($query, array $filters)
    {
        // Filtre par nom/prénom
        if (!empty($filters['search_nom'])) {
            $query->whereHas('candidat', function($q) use ($filters) {
                $q->where('nom', 'ILIKE', "%{$filters['search_nom']}%")
                  ->orWhere('prenom', 'ILIKE', "%{$filters['search_nom']}%");
            });
        }
        
        // Filtre par âge (min/max)
        if (!empty($filters['age_min']) || !empty($filters['age_max'])) {
            $query->whereHas('candidat', function($q) use ($filters) {
                if (!empty($filters['age_min'])) {
                    $dateMax = now()->subYears($filters['age_min'])->format('Y-m-d');
                    $q->where('date_naissance', '<=', $dateMax);
                }
                if (!empty($filters['age_max'])) {
                    $dateMin = now()->subYears($filters['age_max'])->format('Y-m-d');
                    $q->where('date_naissance', '>=', $dateMin);
                }
            });
        }
        
        // Filtre par compétences
        if (!empty($filters['search_competences'])) {
            $query->whereHas('candidat', function($q) use ($filters) {
                $q->where('competences', 'ILIKE', "%{$filters['search_competences']}%");
            });
        }
        
        // Filtre par statut de candidature
        if (!empty($filters['filter_statut'])) {
            $query->where('statut', $filters['filter_statut']);
        }
        
        return $query;
    }
    
    /**
     * Enrichit les candidatures avec les scores et l'âge
     * 
     * @param \Illuminate\Support\Collection $candidatures
     * @return \Illuminate\Support\Collection
     */
    private function enrichCandidatures($candidatures)
    {
        // Récupérer tous les IDs de candidatures pour optimiser les requêtes
        $candidatureIds = $candidatures->pluck('id')->toArray();
        
        // Récupérer tous les résultats de tests en une seule requête
        $resultatsTests = \App\Models\ResultatTest::whereIn('candidature_id', $candidatureIds)
            ->get()
            ->keyBy('candidature_id');
        
        // Récupérer toutes les évaluations d'entretiens en une seule requête
        $evaluations = \App\Models\EvaluationEntretien::whereHas('entretien', function($q) use ($candidatureIds) {
            $q->whereIn('candidature_id', $candidatureIds);
        })->with('entretien')->get()->keyBy('entretien.candidature_id');
        
        // Enrichir chaque candidature
        return $candidatures->map(function($candidature) use ($resultatsTests, $evaluations) {
            // Score du test
            $candidature->score_test = $resultatsTests->get($candidature->id)->score ?? null;
            
            // Note d'entretien (convertie sur 100)
            $evaluation = $evaluations->get($candidature->id);
            $candidature->note_entretien = $evaluation 
                ? round(($evaluation->note / 20) * 100, 2) 
                : null;
            
            // Calculer l'âge du candidat
            if ($candidature->candidat->date_naissance) {
                $candidature->candidat->age = \Carbon\Carbon::parse($candidature->candidat->date_naissance)->age;
            }
            
            return $candidature;
        });
    }
}
