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

        // Après création de l'employé
        NotificationService::send(
            'employe',
            'candidat',
            $candidatId,
            [
                'message' => "Félicitations ! Vous êtes désormais enregistré comme employé actif.",
                'matricule' => $matricule
            ]
        );

        // 🔔 Notification RH
        NotificationService::send(
            'employe',
            'rh',
            0,
            [
                'message' => "Le candidat {$contrat->candidature->candidat->nom} est maintenant un employé actif ({$matricule})."
            ]
        );

    }
}
