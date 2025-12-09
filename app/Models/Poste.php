<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poste extends Model
{
    protected $table = 'postes';
    protected $fillable = [
        'code',
        'titre',
        'description',
        'departement_id',
        'niveau_hierarchique',
        'salaire_min',
        'salaire_max'
    ];
    public $timestamps = false;

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    public function fiches()
    {
        return $this->hasMany(FicheEmploye::class, 'poste_id');
    }
}
