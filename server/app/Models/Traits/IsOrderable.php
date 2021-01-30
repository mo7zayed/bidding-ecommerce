<?php

namespace App\Models\Traits;

trait IsOrderable
{
    /**
     * Get resource ordered by order field.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $q
     * @param  string $dir.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($q, $dir = 'ASC')
    {
        return $q->orderBy('order', $dir);
    }
}
