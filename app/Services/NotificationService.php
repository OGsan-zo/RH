<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function send($type, $notifiableType, $notifiableId, $data = [])
    {
        return Notification::create([
            'notifiable_type' => $notifiableType,   // ex: 'Candidat' ou 'RH'
            'notifiable_id'   => $notifiableId,
            'type'            => $type,             // ex: 'test', 'entretien', 'contrat', 'decision'
            'data'            => json_encode($data),
            'created_at'      => now()
        ]);
    }
}
