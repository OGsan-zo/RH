<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRh extends Model
{
    protected $table = 'documents_rh';
    protected $fillable = [
        'employe_id',
        'type_document_id',
        'nom_fichier',
        'chemin_fichier',
        'type_mime',
        'taille_bytes',
        'date_emission',
        'date_expiration',
        'valide',
        'remarques'
    ];
    public $timestamps = false;

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function typeDocument()
    {
        return $this->belongsTo(TypeDocument::class, 'type_document_id');
    }
}
