<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultatTest extends Model
{
    protected $table = 'resultats_tests';
    protected $fillable = ['candidature_id', 'test_id', 'score', 'date_passage'];
    public $timestamps = false;

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function reponsesCandidat()
    {
        return $this->hasMany(CandidatReponse::class, 'resultat_test_id');
    }
}
