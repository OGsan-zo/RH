<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlerteCongé extends Model
{
    protected $table = 'alertes_conges';
    protected $fillable = [
        'employe_id',
        'type_alerte',
        'message',
        'est_resolue',
        'date_resolution'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function estNonResolue()
    {
        return !$this->est_resolue;
    }

    public function estResolue()
    {
        return $this->est_resolue;
    }

    public function resoudre()
    {
        $this->est_resolue = true;
        $this->date_resolution = now();
        $this->save();
        return $this;
    }
}
