<?php

namespace App\Http\Resources;

use App\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class KitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => new ProductResource(Product::find($this->product_id)),
            'related' => new ProductResource(Product::find($this->related_id)),
            'amount' => $this->amount,
        ];
    }
}
