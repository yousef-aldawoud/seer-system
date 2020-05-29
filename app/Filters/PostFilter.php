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

    public function title($order = 'desc'){
        if($order === 'desc'){
            return $this->builder->orderBy('title','desc');
        }
        return $this->builder->orderBy('title');
    }

    public function description($order = 'desc'){
        if($order === 'desc'){
            return $this->builder->orderBy('description','desc');
        }
        return $this->builder->orderBy('description');
    }

    public function date($order='desc'){
        if($order === 'desc'){
            return $this->builder->orderBy('created_at','desc');
        }
        return $this->builder->orderBy('created_at');
    }
}