<?php

namespace App\Models\Order;

use App\Models\Product\Kit;
use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Checkout extends Model
{
    public static $STATUSES = [
        'in_progress' => 'В корзине',
        'finished' => 'Завершен',
    ];

    protected $fillable = [
        'status',
        'user_id',
        'product_id',
        'kit_id',
        'order_id',
        'quantity',
        'price',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
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
    public function kit(): BelongsTo
    {
        return $this->belongsTo(Kit::class);
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
