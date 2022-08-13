<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
    ];

    public function contact()
    {
        return $this->belongsTo('App\Models\Contact', 'contact_id');
    }

    public function message()
    {
        return $this->hasMany('App\Models\Message', 'chat_id', 'id');
    }
}
