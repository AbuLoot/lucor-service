<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'order_id');
    }

    public function products()
    {
    	return $this->belongsToMany('App\Product', 'product_order');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
}
