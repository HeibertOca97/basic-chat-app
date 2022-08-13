<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user2_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\Models\User', 'user2_id');
    }

    public function chat()
    {
        return $this->belongsTo('App\Models\Chat', 'id', 'contact_id');
    }
}
