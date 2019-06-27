<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = 'apps';

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
