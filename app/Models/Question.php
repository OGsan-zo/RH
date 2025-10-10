<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = ['test_id', 'intitule', 'points'];
    public $timestamps = false;

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'question_id');
    }
}
