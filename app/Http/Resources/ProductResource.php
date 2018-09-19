<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'price' => $this->computed_price,
            'thumbnail' => $this->getFirstMediaUrl('product', 'thumb'),
            'colors' => json_encode($this->colors),
            'rate' => (int) $this->stars,
            'url' => route('app.product.show', $this),
        ];
    }
}
