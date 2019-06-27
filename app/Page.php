<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Kalnoy\Nestedset\NodeTrait;

class Page extends Model
{
	use NodeTrait;

    protected $table = 'pages';

    public function news()
    {
        return $this->hasMany('App\News');
    }
}
