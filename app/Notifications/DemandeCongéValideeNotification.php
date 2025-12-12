<?php

namespace App\Notifications;

use App\Models\DemandeCongé;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class DemandeCongéValideeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $demandeCongé;
    protected $estApprouvee;

    public function __construct(DemandeCongé $demandeCongé, bool $estApprouvee = true)
    {
        $this->demandeCongé = $demandeCongé;
        $this->estApprouvee = $estApprouvee;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $statut = $this->estApprouvee ? 'approuvée' : 'rejetée';
        $icon = $this->estApprouvee ? '✅' : '❌';

        return [
            'titre' => "{$icon} Demande de Congé {$statut}",
            'message' => "Votre demande de congé du {$this->demandeCongé->date_debut} au {$this->demandeCongé->date_fin} a été {$statut}.",
            'type' => $this->estApprouvee ? 'success' : 'danger',
            'demande_conge_id' => $this->demandeCongé->id,
            'lien' => route('demandes-conges.show', $this->demandeCongé->id),
            'commentaire' => $this->demandeCongé->commentaire_validation,
        ];
    }
}
