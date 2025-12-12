<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CalculerSoldesCongesJob;
use App\Models\SoldeCongé;
use App\Models\Employe;

class SoldeCongesAdminController extends Controller
{
    /**
     * Déclencher le calcul des soldes manuellement
     */
    public function calculerSoldes()
    {
        try {
            CalculerSoldesCongesJob::dispatch();
            
            return redirect()->back()->with('success', '✅ Calcul des soldes lancé ! Les soldes seront calculés en arrière-plan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Afficher le statut des soldes
     */
    public function statut()
    {
        $employes = Employe::with(['candidat', 'soldesConges.typeCongé'])->get();
        
        $stats = [
            'total_employes' => $employes->count(),
            'employes_avec_soldes' => $employes->filter(fn($e) => $e->soldesConges->count() > 0)->count(),
            'employes_sans_soldes' => $employes->filter(fn($e) => $e->soldesConges->count() === 0)->count(),
        ];

        return view('rh.soldes-admin.statut', compact('employes', 'stats'));
    }
}
