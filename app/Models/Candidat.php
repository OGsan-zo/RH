<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $table = 'candidats';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'date_naissance',
        'cv_path',
        'statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
