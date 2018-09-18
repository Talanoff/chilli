<?php

namespace App\Models\Product;

use App\Models\Order\Checkout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kit extends Model
{
    protected $fillable = [
        'product_id',
        'related_id',
        'amount',
    ];

    protected $appends = [
        'sku'
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

    /**
     * @return HasMany
     */
    public function checkout(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    /**
     * @return string
     */
    public function getSkuAttribute(): string
    {
        return sprintf("%05d", $this->id + 1000);
    }
}
