<?php


namespace App\Scoping\Traits;

use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;

trait Scopeable
{
    /**
     * scopeWithScopes.
     *
     * @param  Builder $builder
     * @param  array   $scopes.
     *
     * @return Builder
     */
    public function scopeWithScopes(Builder $builder, array $scopes = []) : Builder
    {
        $scoper = new Scoper(request());

        return $scoper->apply($builder, $scopes);
    }
}
