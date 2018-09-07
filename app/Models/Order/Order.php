<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Order extends Model
{
    public static $STATUSES = [
        'processing' => 'В обработке',
        'finished' => 'Завершен',
        'declined' => 'Отклонен',
    ];

    public static $DELIVERY = [
        'self' => 'Самовывоз',
        'np' => 'Новая почта',
        'courier' => 'Курьер',
    ];

    protected $fillable = [
        'user_id',
        'status',
        'delivery',
        'city',
        'warehouse',
        'address',
        'message',
    ];

    protected $with = [
        'user',
    ];

    protected $appends = [
        'products',
        'amount',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function checkout(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    /**
     * @return HasManyThrough
     */
    //    public function products(): HasManyThrough
    //    {
    //        return $this->hasManyThrough(Product::class, Checkout::class);
    //    }

    /**
     * @return number
     */
    public function getAmountAttribute()
    {
        return $this->checkout->map(function ($c) {
            return $c->product->price * $c->quantity;
        })->sum();
    }

    /**
     * @return Collection
     */
    public function getProductsAttribute(): Collection
    {
        $products = $this->user->processedCheckout->pluck('product_id');
        return Product::query()->whereIn('id', $products)->get();
    }
}
