<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliationSociale extends Model
{
    protected $table = 'affiliations_sociales';
    protected $fillable = [
        'contrat_id', 'organisme', 'numero_affiliation', 'taux_cotisation', 'date_affiliation'
    ];
    public $timestamps = false;

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id');
    }
}
