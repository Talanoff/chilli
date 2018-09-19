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
            'product' => isset($this->product_id) ? new ProductResource($this->product) : null,
            'kit' => isset($this->kit_id) ? new KitResource($this->kit) : null,
            'quantity' => $this->quantity,
            'amount' => ($this->product_id ? $this->product->computed_price : $this->kit->amount) * $this->quantity,
        ];
    }
}
