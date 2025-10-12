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

    const STATUTS = [
        'actif',
        'renouvelé',
        'fin_essai',
        'termine',
        'expiré',
        'clos',
        'suspendu'
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature_id');
    }
}
