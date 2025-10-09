<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departements';
    protected $primaryKey = 'id';

    protected $fillable = ['nom'];

    public $timestamps = false; // ta table n’a pas created_at / updated_at
}
