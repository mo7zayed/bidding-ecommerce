<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Helpers\Http\Respond;
use App\Http\Requests\BidsRequest;
use App\Models\Product;
use App\Scoping\Scopes\CategoryScope;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $index = Product::with('variations.type', 'variations.stock', 'variations.product')->withScopes($this->scopes())->paginate(20);

        return Respond::make(
            ProductIndexResource::collection($index)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load(['variations.type', 'variations.stock', 'variations.product', 'first_bid', 'last_bid']);

        return Respond::make(
            new ProductResource($product)
        );
    }

    /**
     * Scopes That Will Be Used In Product.
     *
     * @return array
     */
    private function scopes() : array
    {
        return [
            'category' => new CategoryScope,
        ];
    }
}
