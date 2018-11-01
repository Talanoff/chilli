<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public static $STATUSES = [
        'processing' => 'В обработке',
        'no_dial' => 'Не дозвон',
        'finished' => 'Завершен',
        'declined' => 'Отклонен',
    ];

    public static $DELIVERY = [
        'self' => 'Самовывоз',
        'np' => 'Новая почта',
        'courier' => 'Курьер',
    ];

    public static $PAYMENT = [
        'receipt' => 'Оплата при получении',
        'transfer' => 'Оплата на карту',
    ];

    protected $fillable = [
        'user_id',
        'status',
        'delivery',
        'city',
        'warehouse',
        'address',
        'message',
        'payment',
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
     * @return number
     */
    public function getAmountAttribute()
    {
        return $this->checkout->map(function ($item) {
            return $item->price * $item->quantity;
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

    public static function boot()
    {
        parent::boot();

        self::addGlobalScope('ordered', function () {
            self::orderByRaw("FIELD(status , 'processing') DESC")
                ->orderByRaw("FIELD(status , 'no_dial') DESC")
                ->orderByRaw("FIELD(status , 'finished') DESC");
        });
    }
}
