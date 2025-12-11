<?php

namespace App\Services;

use App\Models\Employe;
use App\Models\SoldeCongé;
use App\Models\TypeCongé;
use Carbon\Carbon;

class CalculSoldeService
{
    public function calculerSoldeAnnuel(Employe $employe, TypeCongé $typeCongé)
    {
        $dateDebut = Carbon::now()->startOfYear();
        $dateFin = Carbon::now()->endOfYear();

        $solde = SoldeCongé::where('employe_id', $employe->id)
            ->where('type_conge_id', $typeCongé->id)
            ->where('date_debut_periode', $dateDebut->toDateString())
            ->where('date_fin_periode', $dateFin->toDateString())
            ->first();

        if (!$solde) {
            $solde = $this->creerNouveauSolde($employe, $typeCongé, $dateDebut, $dateFin);
        }

        return $solde;
    }

    public function creerNouveauSolde(Employe $employe, TypeCongé $typeCongé, Carbon $dateDebut, Carbon $dateFin)
    {
        $joursAcquis = $this->calculerJoursAcquis($employe, $typeCongé);

        return SoldeCongé::create([
            'employe_id' => $employe->id,
            'type_conge_id' => $typeCongé->id,
            'jours_acquis' => $joursAcquis,
            'jours_utilises' => 0,
            'jours_restants' => $joursAcquis,
            'jours_reportes' => 0,
            'date_debut_periode' => $dateDebut->toDateString(),
            'date_fin_periode' => $dateFin->toDateString(),
            'derniere_mise_a_jour' => now()
        ]);
    }

    public function calculerJoursAcquis(Employe $employe, TypeCongé $typeCongé)
    {
        if ($typeCongé->nom === 'Congé Payé') {
            return $this->calculerCongéPayé($employe);
        }

        return $typeCongé->jours_annuels;
    }

    public function calculerCongéPayé(Employe $employe)
    {
        $ficheEmploye = $employe->ficheEmploye;
        if (!$ficheEmploye) {
            return 0;
        }

        $dateEmbauche = Carbon::parse($ficheEmploye->date_embauche);
        $moisService = $dateEmbauche->diffInMonths(Carbon::now());

        return min($moisService * 2.5, 30);
    }

    public function mettreAJourSolde(SoldeCongé $solde, $joursUtilises)
    {
        $solde->jours_utilises += $joursUtilises;
        $solde->jours_restants = $solde->calculerJoursRestants();
        $solde->derniere_mise_a_jour = now();
        $solde->save();

        return $solde;
    }
}
