<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidatReponse extends Model
{
    protected $table = 'candidat_reponses';
    protected $fillable = ['resultat_test_id', 'question_id', 'reponse_id', 'est_correcte'];
    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function reponse()
    {
        return $this->belongsTo(Reponse::class, 'reponse_id');
    }

    public function resultat()
    {
        return $this->belongsTo(ResultatTest::class, 'resultat_test_id');
    }
}
