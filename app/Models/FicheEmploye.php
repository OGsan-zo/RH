<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FicheEmploye extends Model
{
    protected $table = 'fiches_employes';
    protected $fillable = [
        'employe_id',
        'cin',
        'lieu_naissance',
        'nationalite',
        'situation_matrimoniale_id',
        'nombre_enfants',
        'telephone',
        'telephone_secondaire',
        'adresse_personnelle',
        'ville',
        'code_postal',
        'poste_id',
        'photo_path',
        'iban',
        'bic',
        'titulaire_compte',
        'date_naissance',
        'date_embauche',
        'date_fin_prevue'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    public function situationMatrimoniale()
    {
        return $this->belongsTo(EnumSituationMatrimoniale::class, 'situation_matrimoniale_id');
    }
}
