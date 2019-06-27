<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
}
