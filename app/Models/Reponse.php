<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    protected $table = 'reponses';
    protected $fillable = ['question_id', 'texte', 'est_correcte'];
    protected $casts = ['est_correcte' => 'boolean'];
    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
