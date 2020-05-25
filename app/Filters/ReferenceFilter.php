<?php
namespace App\Filters;

use App\Filters\Filter;

class ReferenceFilter extends Filter{
    
    public function q($q=""){
        if($q===""){
            return $this->builder;
        }
        return $this->builder
        ->where("title","like","%$q%")
        ->orWhere("author","like","%$q%");
    }
    
    
}