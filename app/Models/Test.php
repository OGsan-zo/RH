<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';
    protected $fillable = ['annonce_id', 'titre', 'description', 'duree'];
    public $timestamps = false;

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id');
    }
}
