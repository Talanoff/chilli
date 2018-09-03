<?php

namespace App\Models\Order;

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
        'quantity',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Returns anonymous user checkout
     *
     * @return mixed
     */
    public static function anonymous()
    {
        return self::whereUserId(session()->getId())
                   ->whereStatus('in_progress');
    }
}
