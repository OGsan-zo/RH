<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnumStatutMobilite extends Model
{
    protected $table = 'enum_statuts_mobilites';
    protected $fillable = ['code', 'libelle'];
    public $timestamps = false;
}
