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
            'sku' => $this->sku,
            'product' => new ProductResource(Product::find($this->product_id)),
            'related' => new ProductResource(Product::find($this->related_id)),
            'old_price' => Product::where('id', $this->product_id)->first()->computed_price + Product::where('id',
                    $this->related_id)->first()->computed_price,
            'amount' => $this->amount,
        ];
    }
}
