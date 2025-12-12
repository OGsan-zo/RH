<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Employe;
use App\Models\TypeCongé;
use App\Models\SoldeCongé;
use Carbon\Carbon;

class CalculerSoldesCongesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $employes = Employe::all();
        
        foreach ($employes as $employe) {
            $this->calculerSoldesEmploye($employe);
        }
    }

    private function calculerSoldesEmploye(Employe $employe)
    {
        $typesConges = TypeCongé::where('est_actif', true)->get();
        
        foreach ($typesConges as $type) {
            $this->calculerSoldeParType($employe, $type);
        }
    }

    private function calculerSoldeParType(Employe $employe, TypeCongé $type)
    {
        $dateDebut = Carbon::now()->startOfYear();
        $dateFin = Carbon::now()->endOfYear();

        // Vérifier si un solde existe déjà pour cette période
        $soldeExistant = SoldeCongé::where('employe_id', $employe->id)
            ->where('type_conge_id', $type->id)
            ->where('date_debut_periode', $dateDebut)
            ->where('date_fin_periode', $dateFin)
            ->first();

        if ($soldeExistant) {
            // Solde existe déjà, ne pas recalculer
            return;
        }

        // Calculer les jours acquis (2,5 jours par mois = 30 jours par an)
        $joursAcquis = 30;

        // Récupérer les jours reportés de l'année précédente (max 5 jours)
        $joursReportes = $this->calculerJoursReportes($employe, $type);

        // Créer le nouveau solde
        SoldeCongé::create([
            'employe_id' => $employe->id,
            'type_conge_id' => $type->id,
            'jours_acquis' => $joursAcquis,
            'jours_utilises' => 0,
            'jours_restants' => $joursAcquis + $joursReportes,
            'jours_reportes' => $joursReportes,
            'date_debut_periode' => $dateDebut,
            'date_fin_periode' => $dateFin,
            'derniere_mise_a_jour' => now()
        ]);
    }

    private function calculerJoursReportes(Employe $employe, TypeCongé $type)
    {
        // Récupérer le solde de l'année précédente
        $anneePassee = Carbon::now()->subYear()->year;
        $dateDebut = Carbon::createFromDate($anneePassee, 1, 1);
        $dateFin = Carbon::createFromDate($anneePassee, 12, 31);

        $soldeAnneePassee = SoldeCongé::where('employe_id', $employe->id)
            ->where('type_conge_id', $type->id)
            ->where('date_debut_periode', $dateDebut)
            ->where('date_fin_periode', $dateFin)
            ->first();

        if (!$soldeAnneePassee) {
            return 0;
        }

        // Calculer les jours restants non utilisés
        $joursRestants = $soldeAnneePassee->jours_acquis + $soldeAnneePassee->jours_reportes - $soldeAnneePassee->jours_utilises;

        // Reporter maximum 5 jours (selon la politique)
        return min($joursRestants, 5);
    }
}
