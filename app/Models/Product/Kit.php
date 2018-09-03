<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kit extends Model
{
    protected $fillable = [
        'product_id',
        'related_id',
        'amount',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function related(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
