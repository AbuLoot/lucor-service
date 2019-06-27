<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    protected $table = 'categories';

    public function cities()
    {
        return $this->hasMany('App\City');
    }

    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}