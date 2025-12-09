<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnumTypeMouvement extends Model
{
    protected $table = 'enum_types_mouvements';
    protected $fillable = ['code', 'libelle'];
    public $timestamps = false;
}
