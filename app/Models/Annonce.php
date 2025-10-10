<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $table = 'annonces';
    protected $primaryKey = 'id';

    protected $fillable = [
        'departement_id',
        'titre',
        'description',
        'competences_requises',
        'niveau_requis',
        'date_publication',
        'date_limite',
        'statut'
    ];

    public $timestamps = false;

    // Relation : une annonce appartient à un département
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
