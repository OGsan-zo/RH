<?php

namespace App\Services;

use App\Models\DemandeCongé;
use App\Models\HistoriqueCongé;
use App\Models\SoldeCongé;
use App\Models\Employe;
use App\Models\User;
use App\Notifications\DemandeCongéValideeNotification;
use App\Notifications\NouvelleDemandeCongeNotification;
use Carbon\Carbon;

class CongéService
{
    protected $calculSoldeService;

    public function __construct(CalculSoldeService $calculSoldeService)
    {
        $this->calculSoldeService = $calculSoldeService;
    }

    public function creerDemandeCongé($data)
    {
        $dateDebut = Carbon::parse($data['date_debut']);
        $dateFin = Carbon::parse($data['date_fin']);
        $nombreJours = $dateDebut->diffInDays($dateFin) + 1;

        $demande = DemandeCongé::create([
            'employe_id' => $data['employe_id'],
            'type_conge_id' => $data['type_conge_id'],
            'date_debut' => $dateDebut->toDateString(),
            'date_fin' => $dateFin->toDateString(),
            'nombre_jours' => $nombreJours,
            'motif' => $data['motif'] ?? null,
            'certificat_medical_path' => $data['certificat_medical_path'] ?? null,
            'statut_id' => 1,
            'date_creation' => now(),
            'date_modification' => now()
        ]);

        // Notifier le manager et la RH
        $this->notifierNouvelleDemande($demande);

        return $demande;
    }

    public function validerDemandeCongé(DemandeCongé $demande, $validateurId, $approuvee = true, $commentaire = null)
    {
        if ($approuvee) {
            $demande->statut_id = 2;
            $this->enregistrerCongéPris($demande);
        } else {
            $demande->statut_id = 3;
        }

        $demande->validateur_id = $validateurId;
        $demande->date_validation = now();
        $demande->commentaire_validation = $commentaire;
        $demande->date_modification = now();
        $demande->save();

        // Notifier l'employé de la validation
        $this->notifierValidationDemande($demande, $approuvee);

        return $demande;
    }

    public function enregistrerCongéPris(DemandeCongé $demande)
    {
        $solde = SoldeCongé::where('employe_id', $demande->employe_id)
            ->where('type_conge_id', $demande->type_conge_id)
            ->first();

        if ($solde) {
            $this->calculSoldeService->mettreAJourSolde($solde, $demande->nombre_jours);
        }

        HistoriqueCongé::create([
            'employe_id' => $demande->employe_id,
            'demande_conge_id' => $demande->id,
            'type_conge_id' => $demande->type_conge_id,
            'date_debut' => $demande->date_debut,
            'date_fin' => $demande->date_fin,
            'nombre_jours_pris' => $demande->nombre_jours,
            'motif' => $demande->motif,
            'validateur_id' => $demande->validateur_id,
            'date_enregistrement' => now()
        ]);
    }

    public function annulerDemandeCongé(DemandeCongé $demande)
    {
        $demande->statut_id = 4;
        $demande->date_modification = now();
        $demande->save();

        return $demande;
    }

    public function verifierDisponibilite(DemandeCongé $demande)
    {
        $solde = SoldeCongé::where('employe_id', $demande->employe_id)
            ->where('type_conge_id', $demande->type_conge_id)
            ->first();

        if (!$solde) {
            return false;
        }

        return $solde->jours_restants >= $demande->nombre_jours;
    }

    /**
     * Notifier le manager et la RH d'une nouvelle demande de congé
     */
    private function notifierNouvelleDemande(DemandeCongé $demande)
    {
        // Charger l'employé avec ses relations
        $demande->load('employe.manager');

        // Notifier le manager s'il existe
        if ($demande->employe->manager) {
            $manager = $demande->employe->manager;
            if ($manager->user_id) {
                $user = User::find($manager->user_id);
                if ($user) {
                    $user->notify(new NouvelleDemandeCongeNotification($demande));
                }
            }
        }

        // Notifier tous les RH
        $rhUsers = User::where('role', 'rh')->get();
        foreach ($rhUsers as $rhUser) {
            $rhUser->notify(new NouvelleDemandeCongeNotification($demande));
        }
    }

    /**
     * Notifier l'employé de la validation de sa demande
     */
    private function notifierValidationDemande(DemandeCongé $demande, bool $approuvee)
    {
        // Charger l'employé avec ses relations
        $demande->load('employe');

        // Notifier l'employé s'il a un compte utilisateur
        if ($demande->employe->user_id) {
            $user = User::find($demande->employe->user_id);
            if ($user) {
                $user->notify(new DemandeCongéValideeNotification($demande, $approuvee));
            }
        }
    }
}
