<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    protected $fillable = [
        'employe_id',
        'ancien_poste_id',
        'nouveau_poste_id',
        'ancien_salaire',
        'nouveau_salaire',
        'date_promotion',
        'date_effet',
        'motif',
        'decision_numero'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function ancienPoste()
    {
        return $this->belongsTo(Poste::class, 'ancien_poste_id');
    }

    public function nouveauPoste()
    {
        return $this->belongsTo(Poste::class, 'nouveau_poste_id');
    }
}
