<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $table = 'candidats';
    protected $fillable = [
        'user_id', 'nom', 'prenom', 'date_naissance', 'email', 'cv_path', 'competences', 'statut'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'candidat_id');
    }
}
