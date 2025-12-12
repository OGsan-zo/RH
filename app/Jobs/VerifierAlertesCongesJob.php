<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Employe;
use App\Models\DemandeCongé;
use App\Models\SoldeCongé;
use App\Models\AlerteCongé;
use Carbon\Carbon;

class VerifierAlertesCongesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $employes = Employe::all();

        foreach ($employes as $employe) {
            $this->verifierAlertesEmploye($employe);
        }
    }

    private function verifierAlertesEmploye(Employe $employe)
    {
        // 1. Vérifier les congés non validés depuis 7 jours
        $this->verifierCongesNonValides($employe);

        // 2. Vérifier les absences répétées
        $this->verifierAbsencesRepetees($employe);

        // 3. Vérifier les soldes faibles
        $this->verifierSoldesFaibles($employe);

        // 4. Vérifier l'expiration des congés
        $this->verifierExpirationConges($employe);
    }

    /**
     * Alerte : Congés non validés depuis 7 jours
     */
    private function verifierCongesNonValides(Employe $employe)
    {
        $demandesAnciens = DemandeCongé::where('employe_id', $employe->id)
            ->where('statut_id', 1) // En attente
            ->where('date_creation', '<', Carbon::now()->subDays(7))
            ->get();

        if ($demandesAnciens->count() > 0) {
            $nombreDemandes = $demandesAnciens->count();
            $message = "Vous avez {$nombreDemandes} demande(s) de congé en attente depuis plus de 7 jours.";

            $this->creerAlerte($employe, 'conges_non_valides', $message);
        } else {
            // Résoudre l'alerte si elle existe
            $this->resoudreAlerte($employe, 'conges_non_valides');
        }
    }

    /**
     * Alerte : Absences répétées (>3 fois par mois)
     */
    private function verifierAbsencesRepetees(Employe $employe)
    {
        $dateDebut = Carbon::now()->startOfMonth();
        $dateFin = Carbon::now()->endOfMonth();

        $absences = DemandeCongé::where('employe_id', $employe->id)
            ->where('statut_id', 2) // Approuvées
            ->whereBetween('date_debut', [$dateDebut, $dateFin])
            ->count();

        if ($absences > 3) {
            $message = "Vous avez {$absences} absences ce mois-ci (plus de 3). Veuillez justifier si nécessaire.";
            $this->creerAlerte($employe, 'absences_repetees', $message);
        } else {
            $this->resoudreAlerte($employe, 'absences_repetees');
        }
    }

    /**
     * Alerte : Soldes faibles (<5 jours)
     */
    private function verifierSoldesFaibles(Employe $employe)
    {
        $soldesFaibles = SoldeCongé::where('employe_id', $employe->id)
            ->where('jours_restants', '<', 5)
            ->where('jours_restants', '>', 0)
            ->get();

        if ($soldesFaibles->count() > 0) {
            $details = $soldesFaibles->map(function ($solde) {
                return "{$solde->typeCongé->nom} ({$solde->jours_restants} jours)";
            })->implode(', ');

            $message = "Vos soldes de congés sont faibles : {$details}. Pensez à les utiliser avant expiration.";
            $this->creerAlerte($employe, 'soldes_faibles', $message);
        } else {
            $this->resoudreAlerte($employe, 'soldes_faibles');
        }
    }

    /**
     * Alerte : Expiration de congés non utilisés
     */
    private function verifierExpirationConges(Employe $employe)
    {
        $dateExpiration = Carbon::now()->addDays(30); // Alerte 30 jours avant expiration

        $soldesExpiration = SoldeCongé::where('employe_id', $employe->id)
            ->where('date_fin_periode', '<=', $dateExpiration)
            ->where('date_fin_periode', '>', Carbon::now())
            ->where('jours_restants', '>', 0)
            ->get();

        if ($soldesExpiration->count() > 0) {
            $details = $soldesExpiration->map(function ($solde) {
                $jours = $solde->date_fin_periode->diffInDays(Carbon::now());
                return "{$solde->typeCongé->nom} (expire dans {$jours} jours)";
            })->implode(', ');

            $message = "Vos congés expirent bientôt : {$details}. Utilisez-les rapidement !";
            $this->creerAlerte($employe, 'expiration_conges', $message);
        } else {
            $this->resoudreAlerte($employe, 'expiration_conges');
        }
    }

    /**
     * Créer une alerte (ou la mettre à jour si elle existe déjà)
     */
    private function creerAlerte(Employe $employe, string $typeAlerte, string $message)
    {
        // Vérifier si une alerte non résolue existe déjà
        $alerteExistante = AlerteCongé::where('employe_id', $employe->id)
            ->where('type_alerte', $typeAlerte)
            ->where('est_resolue', false)
            ->first();

        if (!$alerteExistante) {
            AlerteCongé::create([
                'employe_id' => $employe->id,
                'type_alerte' => $typeAlerte,
                'message' => $message,
                'est_resolue' => false,
            ]);
        }
    }

    /**
     * Résoudre une alerte
     */
    private function resoudreAlerte(Employe $employe, string $typeAlerte)
    {
        AlerteCongé::where('employe_id', $employe->id)
            ->where('type_alerte', $typeAlerte)
            ->where('est_resolue', false)
            ->update([
                'est_resolue' => true,
                'date_resolution' => now()
            ]);
    }
}
