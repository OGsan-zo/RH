<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueCongé extends Model
{
    protected $table = 'historique_conges';
    protected $fillable = [
        'employe_id',
        'demande_conge_id',
        'type_conge_id',
        'date_debut',
        'date_fin',
        'nombre_jours_pris',
        'motif',
        'validateur_id'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function demandeCongé()
    {
        return $this->belongsTo(DemandeCongé::class, 'demande_conge_id');
    }

    public function typeCongé()
    {
        return $this->belongsTo(TypeCongé::class, 'type_conge_id');
    }

    public function validateur()
    {
        return $this->belongsTo(User::class, 'validateur_id');
    }
}
