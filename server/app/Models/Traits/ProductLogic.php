<?php

namespace App\Models\Traits;

trait ProductLogic
{
    /**
     * Check if the variation is in stock.
     *
     * @return bool
     */
    public function inStock(): bool
    {
        return $this->stockCount() > 0;
    }

    /**
     * Get items remaining in the stock.
     *
     * @return integer
     */
    public function stockCount(): int
    {
        return $this->variations->sum(function ($variation) {
            return $variation->stockCount();
        });
    }
}
