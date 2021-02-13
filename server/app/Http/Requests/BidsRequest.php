<?php

namespace App\Http\Requests;

use App\Cart\Money;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class BidsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'bid_value' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $product = Product::findOrFail(request('product_id'));

                    $product->load(['first_bid', 'last_bid']);

                    $productLastBid = $product->last_bid->first();

                    if ($productLastBid && (float) $value <= $productLastBid->bid_value) {
                        $minBidPrice = $productLastBid->bid_value + 1;

                        $minBidValue = (new Money($minBidPrice * 100))->formatted();

                        return $fail("Bid value is invalid. The minimum bid is $minBidValue");
                    }

                    if ((float) $value < config('bidding.min_bid_value')) {
                        return  $fail("Minimum bid value is " . config('bidding.min_bid_value'));
                    }

                    $productFirstBid = $product->first_bid->first();

                    if ($productFirstBid && $productFirstBid->created_at->addHours(1)->isPast()) {
                        return $fail("Bidding time ended good luck next time");
                    }
                }
            ]
        ];
    }
}
