<?php

namespace App\Notifications;

use App\Models\DemandeCongé;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NouvelleDemandeCongeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $demandeCongé;

    public function __construct(DemandeCongé $demandeCongé)
    {
        $this->demandeCongé = $demandeCongé;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'titre' => '📋 Nouvelle Demande de Congé à Valider',
            'message' => "{$this->demandeCongé->employe->candidat->nom} {$this->demandeCongé->employe->candidat->prenom} a soumis une demande de congé du {$this->demandeCongé->date_debut} au {$this->demandeCongé->date_fin}.",
            'type' => 'info',
            'demande_conge_id' => $this->demandeCongé->id,
            'lien' => route('demandes-conges.show', $this->demandeCongé->id),
            'employe_nom' => $this->demandeCongé->employe->candidat->nom . ' ' . $this->demandeCongé->employe->candidat->prenom,
            'type_conge' => $this->demandeCongé->typeCongé->nom,
            'jours' => $this->demandeCongé->nombre_jours,
        ];
    }
}
