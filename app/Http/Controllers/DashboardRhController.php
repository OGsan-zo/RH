<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Entretien;
use Illuminate\Http\Request;

class DashboardRhController extends Controller
{
    /**
     * Affiche le tableau de bord RH avec AdminLTE
     */
    public function index()
    {
        // Statistiques
        $stats = [
            'candidatures' => Candidature::whereIn('statut', ['en_attente', 'test_en_cours', 'en_entretien'])->count(),
            'tests' => Candidature::where('statut', 'test_en_cours')->count(),
            'entretiens' => Entretien::whereDate('date_entretien', '>=', now())->count(),
            'decisions' => Candidature::where('statut', 'en_attente')->count(), // Candidatures en attente de décision
        ];

        // Dernières candidatures (5 plus récentes)
        $dernieresCandidatures = Candidature::with(['candidat', 'annonce'])
            ->orderBy('date_candidature', 'desc')
            ->limit(5)
            ->get();

        // Prochains entretiens (5 prochains)
        $prochainsEntretiens = Entretien::with(['candidature.candidat'])
            ->whereDate('date_entretien', '>=', now())
            ->orderBy('date_entretien', 'asc')
            ->limit(5)
            ->get();

        return view('rh.dashboard-adminlte', compact('stats', 'dernieresCandidatures', 'prochainsEntretiens'));
    }
}
