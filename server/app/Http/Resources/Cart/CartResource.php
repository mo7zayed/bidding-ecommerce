<?php

namespace App\Http\Resources\Cart;

use App\Cart\Cart;
use App\Http\Resources\ProductVariationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cart = resolve(Cart::class);

        return [
            'products' => CartProductVariationResource::collection($this->cart),
            'meta' => [
                'is_empty' => $cart->isEmpty(),
                'subtotal' => $cart->subtotal()->formatted(),
                'total' => $cart->total()->formatted(),
                'changed' => $cart->hasChanged(),
            ],
        ];
    }
}
