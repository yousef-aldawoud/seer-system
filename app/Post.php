<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function references(){
        return $this->belongsToMany("App\Reference");
    }

    public function user(){
        return $this->belongsTo("App\User");
    }
}
