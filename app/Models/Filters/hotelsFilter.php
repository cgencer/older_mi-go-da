<?php

namespace App\Models\Filters;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait hotelsFilter.
 */
trait hotelsFilter
{
    public function username_like(Builder $builder, $value)
    {
        return $builder->where('username', 'like', '%'.$value.'%');
    }
}