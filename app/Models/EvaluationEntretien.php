<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationEntretien extends Model
{
    protected $table = 'evaluations_entretiens';
    protected $fillable = ['entretien_id', 'note', 'remarques'];
    public $timestamps = false;

    public function entretien()
    {
        return $this->belongsTo(Entretien::class, 'entretien_id');
    }
}
