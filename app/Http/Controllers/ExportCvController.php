<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Exports\CandidatsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExportCvController extends Controller
{
    /**
     * Afficher la page d'export
     */
    public function index()
    {
        // Statistiques pour la page
        $stats = [
            'total_candidats' => Candidat::count(),
            'cv_disponibles' => $this->countCvDisponibles(),
            'cv_manquants' => 0,
            'candidatures_total' => \App\Models\Candidature::count(),
        ];

        $stats['cv_manquants'] = $stats['total_candidats'] - $stats['cv_disponibles'];

        // Récupérer quelques candidats pour la prévisualisation
        $candidats = Candidat::with(['candidatures.annonce'])
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return view('rh.export-cv', compact('stats', 'candidats'));
    }

    /**
     * Télécharger le fichier Excel
     */
    public function export()
    {
        $filename = 'export_cv_candidats_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new CandidatsExport, $filename);
    }

    /**
     * Compter les CV disponibles
     */
    private function countCvDisponibles()
    {
        $candidats = Candidat::whereNotNull('cv_path')->get();
        $count = 0;

        foreach ($candidats as $candidat) {
            $cvFullPath = storage_path('app/public/' . $candidat->cv_path);
            if (file_exists($cvFullPath)) {
                $count++;
            }
        }

        return $count;
    }
}
