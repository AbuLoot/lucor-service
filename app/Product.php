<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use SearchableTrait;

    protected $table = 'products';

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.title' => 10,
            'products.description' => 10,
            'products.characteristic' => 10,
            'products.barcode' => 5,
            // 'products.oem' => 5,
        ]
    ];

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function company()
    {
    	return $this->belongsTo('App\Company', 'company_id');
    }

    public function modes()
    {
        return $this->belongsToMany('App\Mode', 'product_mode', 'product_id', 'mode_id');
    }

    public function options()
    {
        return $this->belongsToMany('App\Option', 'product_option', 'product_id', 'option_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order', 'product_order', 'product_id', 'order_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'parent');
    }
}
