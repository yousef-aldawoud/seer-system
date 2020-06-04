<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use Filterable;

    public function posts(){
        return $this->belongsToMany('App\Post');
    }
}
