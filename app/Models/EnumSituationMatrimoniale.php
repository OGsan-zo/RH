<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnumSituationMatrimoniale extends Model
{
    protected $table = 'enum_situations_matrimoniales';
    protected $fillable = ['code', 'libelle'];
    public $timestamps = false;
}
