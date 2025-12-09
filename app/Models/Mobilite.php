<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobilite extends Model
{
    protected $table = 'mobilites';
    protected $fillable = [
        'employe_id',
        'ancien_departement_id',
        'nouveau_departement_id',
        'ancien_poste_id',
        'nouveau_poste_id',
        'date_demande',
        'date_approbation',
        'date_effet',
        'type_mobilite_id',
        'motif',
        'statut_id'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function ancienDepartement()
    {
        return $this->belongsTo(Departement::class, 'ancien_departement_id');
    }

    public function nouveauDepartement()
    {
        return $this->belongsTo(Departement::class, 'nouveau_departement_id');
    }

    public function ancienPoste()
    {
        return $this->belongsTo(Poste::class, 'ancien_poste_id');
    }

    public function nouveauPoste()
    {
        return $this->belongsTo(Poste::class, 'nouveau_poste_id');
    }

    public function typeMobilite()
    {
        return $this->belongsTo(EnumTypeMobilite::class, 'type_mobilite_id');
    }

    public function statut()
    {
        return $this->belongsTo(EnumStatutMobilite::class, 'statut_id');
    }
}
