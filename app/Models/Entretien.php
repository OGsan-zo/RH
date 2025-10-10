<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    protected $table = 'entretiens';
    protected $fillable = [
        'candidature_id', 'date_entretien', 'duree', 'lieu', 'rh_id', 'statut'
    ];
    public $timestamps = false;

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature_id');
    }

    public function rh()
    {
        return $this->belongsTo(User::class, 'rh_id');
    }
}
