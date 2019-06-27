<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    protected $table = 'modes';

    public function products()
    {
    	return $this->belongsToMany('App\Product', 'product_mode');
    }
}
