<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeCongé extends Model
{
    protected $table = 'demandes_conges';
    protected $fillable = [
        'employe_id',
        'type_conge_id',
        'date_debut',
        'date_fin',
        'nombre_jours',
        'motif',
        'certificat_medical_path',
        'statut_id',
        'validateur_id',
        'date_validation',
        'commentaire_validation'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function typeCongé()
    {
        return $this->belongsTo(TypeCongé::class, 'type_conge_id');
    }

    public function validateur()
    {
        return $this->belongsTo(User::class, 'validateur_id');
    }

    public function historiqueConges()
    {
        return $this->hasMany(HistoriqueCongé::class, 'demande_conge_id');
    }

    public function estEnAttente()
    {
        return $this->statut_id === 1;
    }

    public function estApprouvee()
    {
        return $this->statut_id === 2;
    }

    public function estRejetee()
    {
        return $this->statut_id === 3;
    }

    public function estAnnulee()
    {
        return $this->statut_id === 4;
    }
}
