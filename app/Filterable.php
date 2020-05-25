<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\Filter;

trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param  Builder      $query
     * @param  Filter $filters
     * @return Builder
     */
    public function scopeFilter($query, Filter $filters)
    {
        return $filters->apply($query);
    }
}