<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoldeCongé extends Model
{
    protected $table = 'soldes_conges';
    protected $fillable = [
        'employe_id',
        'type_conge_id',
        'jours_acquis',
        'jours_utilises',
        'jours_restants',
        'jours_reportes',
        'date_debut_periode',
        'date_fin_periode',
        'derniere_mise_a_jour'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function typeCongé()
    {
        return $this->belongsTo(TypeCongé::class, 'type_conge_id');
    }

    public function calculerJoursRestants()
    {
        return $this->jours_acquis + $this->jours_reportes - $this->jours_utilises;
    }
}
