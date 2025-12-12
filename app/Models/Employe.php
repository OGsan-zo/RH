<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table = 'employes';
    protected $fillable = [
        'candidat_id',
        'contrat_id',
        'matricule',
        'date_embauche',
        'statut'
    ];
    public $timestamps = false;

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id');
    }

    public function manager()
    {
        return $this->belongsTo(Employe::class, 'manager_id');
    }

    public function subalternes()
    {
        return $this->hasMany(Employe::class, 'manager_id');
    }

    public function soldesConges()
    {
        return $this->hasMany(SoldeCongé::class, 'employe_id');
    }
}
