<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    public function user(){
        $this->belongsTo("App\User");
    }
}
