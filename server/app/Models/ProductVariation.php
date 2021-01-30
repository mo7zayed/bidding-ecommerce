<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Cart\Money;
use App\Models\Traits\HasPrice;
use App\Models\Traits\ProductVariationLogic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariation extends Model
{
    use HasPrice, ProductVariationLogic;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'product_variation_type_id',
        'name',
        'price',
    ];

    /**
     * Price on standard preview.
     *
     * @param  mixed $value
     * @return Money
     */
    public function getPriceAttribute($value): Money
    {
        if (is_null($value)) {
            return $this->product->price;
        }

        return new Money($value);
    }

    /**
     * Variation Type Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type() : HasOne
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    /**
     * Product Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Stocks Relationship actually it can be used as a stock history
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks() : HasMany
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Get related records from `product_variation_stock_view`
     * there is two ways to do it first is to make a new model and assign the table to our db view,
     * second we can use belongsToMany relationship to access the pivot table and get the data that we need.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stock() : BelongsToMany
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_stock_view')->withPivot(['in_stock', 'stock']);
    }
}
