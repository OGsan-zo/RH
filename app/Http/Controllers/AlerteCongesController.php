<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlerteCongé;
use App\Models\Employe;

class AlerteCongesController extends Controller
{
    /**
     * Afficher toutes les alertes
     */
    public function index()
    {
        $userRole = session('user_role');
        $userId = session('user_id');

        if ($userRole === 'rh') {
            // RH voit toutes les alertes
            $alertes = AlerteCongé::with('employe.candidat')
                ->where('est_resolue', false)
                ->orderBy('date_creation', 'desc')
                ->paginate(20);
        } else {
            // Employé voit ses propres alertes
            $employe = Employe::where('user_id', $userId)->first();
            $alertes = AlerteCongé::where('employe_id', $employe->id ?? null)
                ->where('est_resolue', false)
                ->orderBy('date_creation', 'desc')
                ->paginate(20);
        }

        return view('alertes.conges.index', compact('alertes'));
    }

    /**
     * Afficher les alertes résolues
     */
    public function resolues()
    {
        $userRole = session('user_role');
        $userId = session('user_id');

        if ($userRole === 'rh') {
            $alertes = AlerteCongé::with('employe.candidat')
                ->where('est_resolue', true)
                ->orderBy('date_resolution', 'desc')
                ->paginate(20);
        } else {
            $employe = Employe::where('user_id', $userId)->first();
            $alertes = AlerteCongé::where('employe_id', $employe->id ?? null)
                ->where('est_resolue', true)
                ->orderBy('date_resolution', 'desc')
                ->paginate(20);
        }

        return view('alertes.conges.resolues', compact('alertes'));
    }

    /**
     * Marquer une alerte comme résolue
     */
    public function resoudre($alerteId)
    {
        $alerte = AlerteCongé::find($alerteId);

        if (!$alerte) {
            return redirect()->back()->with('error', 'Alerte non trouvée');
        }

        $alerte->resoudre();

        return redirect()->back()->with('success', 'Alerte marquée comme résolue');
    }

    /**
     * Obtenir le nombre d'alertes non résolues (pour AJAX)
     */
    public function compterNonResolues()
    {
        $userRole = session('user_role');
        $userId = session('user_id');

        if ($userRole === 'rh') {
            $count = AlerteCongé::where('est_resolue', false)->count();
        } else {
            $employe = Employe::where('user_id', $userId)->first();
            $count = AlerteCongé::where('employe_id', $employe->id ?? null)
                ->where('est_resolue', false)
                ->count();
        }

        return response()->json(['count' => $count]);
    }

    /**
     * Afficher les statistiques des alertes
     */
    public function statistiques()
    {
        $stats = [
            'conges_non_valides' => AlerteCongé::where('type_alerte', 'conges_non_valides')
                ->where('est_resolue', false)
                ->count(),
            'absences_repetees' => AlerteCongé::where('type_alerte', 'absences_repetees')
                ->where('est_resolue', false)
                ->count(),
            'soldes_faibles' => AlerteCongé::where('type_alerte', 'soldes_faibles')
                ->where('est_resolue', false)
                ->count(),
            'expiration_conges' => AlerteCongé::where('type_alerte', 'expiration_conges')
                ->where('est_resolue', false)
                ->count(),
        ];

        return view('alertes.conges.statistiques', compact('stats'));
    }
}
