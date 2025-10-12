<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'type',
        'data',
        'read_at',
        'created_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }
}
