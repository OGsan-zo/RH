<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Contrat;
use App\Services\NotificationService;

class EmployeController extends Controller
{
    // 1️⃣ Lister employés
    public function index()
    {
        $employes = Employe::with(['candidat','contrat.candidature.annonce'])->get();
        return view('rh.employes.index', compact('employes'));
    }

    // 2️⃣ Créer employé manuellement ou automatiquement
    public static function createFromContrat($contrat)
    {
        $candidatId = $contrat->candidature->candidat_id;
        $matricule = 'EMP-' . str_pad($candidatId, 4, '0', STR_PAD_LEFT);

        // Vérifie si déjà employé
        if (Employe::where('contrat_id', $contrat->id)->exists()) {
            return;
        }

        Employe::create([
            'candidat_id' => $candidatId,
            'contrat_id' => $contrat->id,
            'matricule' => $matricule,
            'date_embauche' => now(),
            'statut' => 'actif'
        ]);

        NotificationService::send(
            'contrat',
            'Candidat',
            $candidatId,
            ['message' => 'Votre contrat est désormais actif. Vous êtes enregistré comme employé.']
        );
    }
}
