<?php
namespace App\Filters;

use App\Filters\Filter;

class UserFilter extends Filter{
    
    public function q($q=""){
        if($q===""){
            return $this->builder;
        }
        return $this->builder
        ->where("name","like","%$q%")
        ->orWhere("email","like","%$q%");
    }
}