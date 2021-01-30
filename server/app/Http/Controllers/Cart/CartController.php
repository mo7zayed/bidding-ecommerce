<?php

namespace App\Http\Controllers\Cart;

use App\Cart\Cart;
use App\Helpers\Http\Respond;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cart $cart)
    {
        $cart->sync();

        return Respond::make(
            new CartResource(auth()->user())
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function store(CartStoreRequest $request, Cart $cart)
    {
        $cart->add($request->products);

        return Respond::make("Cart created");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\ProductVariation  $productVariation
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart\Cart  $cart
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductVariation $productVariation, CartUpdateRequest $request, Cart $cart)
    {
        $cart->update($productVariation->id, $request->quantity);

        return Respond::make("Cart updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductVariation  $productVariation
     * @param  \App\Cart\Cart  $cart
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariation $productVariation, Cart $cart)
    {
        $cart->delete($productVariation->id);

        return Respond::make("Cart deleted");
    }
}
