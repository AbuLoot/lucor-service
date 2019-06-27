<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    public function apps()
    {
        return $this->hasMany('App\App');
    }
}
