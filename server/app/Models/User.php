<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'max_bid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * User cart relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cart() : BelongsToMany
    {
        return $this->belongsToMany(
            ProductVariation::class,
            'user_cart',
            'user_id',
            'product_variation_id'
        )->withPivot('quantity')->withTimestamps();
    }

    /**
     * Addresses Relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * User bids relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'user_id');
    }

    /**
     * User bids relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function autoBiddingProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'user_product_autobids', 'user_id', 'product_id')->withTimestamps();
    }

    /**
     * Checks if the auto bidding is enabled for a product
     *
     * @param integer $product_id
     *
     * @return boolean
     */
    public function isAutobiddingEnabledFor(int $product_id): bool
    {
        return $this->autoBiddingProducts()->where('products.id', $product_id)->exists();
    }

    /**
     * Determines if the user has unlimited max bid
     *
     * @return boolean
     */
    public function hasUnlimitedMaxBid(): bool
    {
        return (float) $this->max_bid == 0;
    }
}
