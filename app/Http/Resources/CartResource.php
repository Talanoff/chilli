<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
//            'product' => new ProductResource($this->product),
//            'kit' => new KitResource($this->kit),
            'quantity' => $this->quantity,
//            'amount' => ($this->product_id ? $this->product->computed_price : $this->kit->amount) * $this->quantity,
        ];
    }
}
