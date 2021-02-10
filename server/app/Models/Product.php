<?php

namespace App\Models;

use App\Models\Traits\HasPrice;
use App\Models\Traits\ProductLogic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Scoping\Traits\Scopeable;

class Product extends Model
{
    use Scopeable, HasPrice, ProductLogic;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Categories Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    /**
     * Variations Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations() : HasMany
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'ASC');
    }

    /**
     * Product bids relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'product_id');
    }

    /**
     * First bid
     */
    public function first_bid()
    {
        return $this->bids()->take(1);
    }

    /**
     * Last bid
     */
    public function last_bid()
    {
        return $this->bids()->orderBy('id', 'DESC')->take(1);
    }
}
