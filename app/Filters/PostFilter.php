<?php
namespace App\Filters;

use App\Filters\Filter;

class PostFilter extends Filter{
    
    public function q($q=""){
        if($q===""){
            return $this->builder;
        }
        return $this->builder
        ->where("title","like","%$q%")
        ->where("title","like","%$q%")
        ->orWhere("content","like","%$q%")
        ->orWhere("description","like","%$q%");
    }
}