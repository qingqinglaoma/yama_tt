<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = [
        'user_id', 'address', 'city', 'state', 'about', 'picture',
    ];

    protected $primaryKey = "user_id"; 
   
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
