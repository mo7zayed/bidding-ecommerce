<?php

namespace App\Models\Traits;

use App\Cart\Money;

trait HasPrice
{
    /**
     * Price on standard preview.
     *
     * @param  mixed $value
     * @return Money
     */
    public function getPriceAttribute($value) : Money
    {
        return new Money($value);
    }

    /**
     * Price formatted for user.
     *
     * @return string
     */
    public function getFormattedPriceAttribute() : string
    {
        return $this->price->formatted();
    }
}
