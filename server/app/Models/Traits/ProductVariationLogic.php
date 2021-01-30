<?php

namespace App\Models\Traits;

trait ProductVariationLogic
{
    /**
     * Is price varies
     *
     * @return boolean
     */
    public function isPriceVaries(): bool
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

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
        return $this->stock->sum('pivot.stock');
    }

    /**
     * Get min stock for a product
     *
     * @param integer $count
     * @return integer
     */
    public function minStock(int $count): int
    {
        return min($count, $this->stockCount());
    }
}
