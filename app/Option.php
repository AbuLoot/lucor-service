<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    public function products()
    {
    	return $this->belongsToMany('App\Product', 'product_option');
    }
}
