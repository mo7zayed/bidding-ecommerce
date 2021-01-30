<?php

namespace App\Scoping\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  mixed $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value) : Builder;
}
