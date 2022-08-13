<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudeFriendShip extends Model
{
    use HasFactory;

    protected $fillable = [
        'emisor_id',
        'receptor_id',
        'status',
    ];

    public function emisor()
    {
        return $this->belongsTo('App\Models\User', 'emisor_id');
    }

    public function receptor()
    {
        return $this->belongsTo('App\Models\User', 'receptor_id');
    }
}
