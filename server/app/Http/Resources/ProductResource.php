<?php

namespace App\Http\Resources;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lastBid = $this->lastBid();

        return array_merge(parent::toArray($request), [
            'variations' => ProductVariationResource::collection($this->variations->groupBy('type.name')),
            'last_bid' => $lastBid
        ]);
    }
}
