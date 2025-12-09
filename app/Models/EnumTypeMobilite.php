<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnumTypeMobilite extends Model
{
    protected $table = 'enum_types_mobilites';
    protected $fillable = ['code', 'libelle'];
    public $timestamps = false;
}
