<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    protected $table = 'types_documents';
    protected $fillable = [
        'code',
        'libelle',
        'obligatoire',
        'description'
    ];
    public $timestamps = false;

    public function documents()
    {
        return $this->hasMany(DocumentRh::class, 'type_document_id');
    }
}
