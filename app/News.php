<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    public function getRusDateAttribute()
    {
    	return strtr(date("j F Y ", strtotime($this->created_at)), trans('data.month'));
    }

    public function Page()
    {
    	return $this->belongsTo('App\Page', 'page_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'parent');
    }
}
