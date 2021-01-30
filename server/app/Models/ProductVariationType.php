<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariationType extends Model
{
    /**
     * Variations Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations() : HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }
}
