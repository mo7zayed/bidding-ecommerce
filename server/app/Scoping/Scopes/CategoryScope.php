<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

class CategoryScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  mixed $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value) : Builder
    {
        return $builder->whereHas('categories', function ($builder) use ($value) {
            $builder->where('slug', $value);
        });
    }
}
