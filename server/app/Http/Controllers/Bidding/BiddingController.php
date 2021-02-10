<?php

namespace App\Http\Controllers\Bidding;

use App\Helpers\Http\Respond;
use App\Http\Controllers\Controller;
use App\Http\Requests\BidsRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BiddingController extends Controller
{

    /**
     * Bid on a product.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, BidsRequest $request)
    {
        DB::transaction(function () use ($product, $request) {
            auth()->user()->bids()->create([
                'product_id' => $product->id,
                'bid_value' => $request->bid_value
            ]);
        }, 5);

        $product->load(['variations.type', 'variations.stock', 'variations.product', 'first_bid', 'last_bid']);

        return Respond::make(
            new ProductResource($product)
        );
    }
}
