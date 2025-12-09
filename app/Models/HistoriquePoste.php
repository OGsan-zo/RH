<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriquePoste extends Model
{
    protected $table = 'historique_postes';
    protected $fillable = [
        'employe_id',
        'poste_id',
        'date_debut',
        'date_fin',
        'titre_poste',
        'departement_id',
        'salaire',
        'type_mouvement_id'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    public function typeMouvement()
    {
        return $this->belongsTo(EnumTypeMouvement::class, 'type_mouvement_id');
    }
}
