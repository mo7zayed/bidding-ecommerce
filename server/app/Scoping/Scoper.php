<?php

namespace App\Scoping;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

class Scoper
{
    /**
     * Http Request Instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  array $scopes
     *
     * @return Builder
     */
    public function apply(Builder $builder, array $scopes) : Builder
    {
        foreach ($scopes as $key => $scope) {
            if (! $scope instanceof Scope) {
                continue;
            }

            if ($this->request->has($key) && !empty($this->request->get($key))) {
                $scope->apply($builder, $this->request->get($key));
            }
        }

        return $builder;
    }
}
