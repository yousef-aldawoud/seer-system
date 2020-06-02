<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostReview extends Model
{
    protected $fillable = [
        'rating', 'comment', 'user_id',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function post(){
        return $this->belongsTo('App\Post');
    }
}
