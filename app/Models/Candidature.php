<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    protected $table = 'candidatures';
    protected $fillable = ['candidat_id', 'annonce_id', 'date_candidature', 'statut', 'score_global', 'note_cv'];
    public $timestamps = false;

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }
    public function contrat()
    {
        return $this->hasOne(\App\Models\Contrat::class, 'candidature_id');
    }

}
