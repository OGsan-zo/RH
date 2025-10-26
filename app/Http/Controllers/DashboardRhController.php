<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Entretien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // Données pour le graphique d'évolution des candidatures (7 derniers mois)
        $evolutionCandidatures = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->locale('fr')->isoFormat('MMM');
            
            $count = Candidature::whereYear('date_candidature', $date->year)
                ->whereMonth('date_candidature', $date->month)
                ->count();
            
            $evolutionCandidatures[] = $count;
        }

        // Données pour le graphique doughnut (répartition par statut)
        $repartitionStatuts = Candidature::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->get();

        $statutLabels = [];
        $statutData = [];
        $statutColors = [
            'en_attente' => 'rgb(108, 117, 125)',
            'test_en_cours' => 'rgb(23, 162, 184)',
            'en_entretien' => 'rgb(255, 193, 7)',
            'retenu' => 'rgb(40, 167, 69)',
            'refuse' => 'rgb(220, 53, 69)',
            'employe' => 'rgb(111, 66, 193)'
        ];

        $statutNoms = [
            'en_attente' => 'En attente',
            'test_en_cours' => 'Test en cours',
            'en_entretien' => 'En entretien',
            'retenu' => 'Retenu',
            'refuse' => 'Refusé',
            'employe' => 'Employé'
        ];

        $colors = [];
        foreach ($repartitionStatuts as $statut) {
            $statutLabels[] = $statutNoms[$statut->statut] ?? ucfirst($statut->statut);
            $statutData[] = $statut->total;
            $colors[] = $statutColors[$statut->statut] ?? 'rgb(128, 128, 128)';
        }

        return view('rh.dashboard-adminlte', compact(
            'stats', 
            'dernieresCandidatures', 
            'prochainsEntretiens',
            'labels',
            'evolutionCandidatures',
            'statutLabels',
            'statutData',
            'colors'
        ));
    }
}
