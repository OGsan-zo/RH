<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeCongé extends Model
{
    protected $table = 'types_conges';
    protected $fillable = [
        'nom',
        'description',
        'jours_annuels',
        'est_remunere',
        'necessite_certificat_medical',
        'est_actif'
    ];
    public $timestamps = false;

    public function demandesConges()
    {
        return $this->hasMany(DemandeCongé::class, 'type_conge_id');
    }

    public function soldesConges()
    {
        return $this->hasMany(SoldeCongé::class, 'type_conge_id');
    }
}
