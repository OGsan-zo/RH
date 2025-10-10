<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    protected $table = 'contrats';
    protected $fillable = [
        'candidature_id', 'type_contrat', 'date_debut', 'date_fin', 'salaire', 'renouvellement', 'statut'
    ];
    public $timestamps = false;

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature_id');
    }
}
