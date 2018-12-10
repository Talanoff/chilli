<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use App\Models\User\User;
use Bigperson\Exchange1C\Interfaces\GroupInterface;
use Bigperson\Exchange1C\Interfaces\OfferInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model implements OfferInterface
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
        'receipt' => 'Наложенный платёж (оплата при получении)',
        'transfer' => 'Оплата на карту Приватбанка',
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

    /**
     * @param mixed|null $context
     *
     * @return array
     */
    public function getExportFields1c($context = null)
    {
        // TODO: Implement getExportFields1c() method.
    }

    /**
     * Возвращаем имя поля в базе данных, в котором хранится ID из 1с
     *
     * @return string
     */
    public static function getIdFieldName1c()
    {
        // TODO: Implement getIdFieldName1c() method.
    }

    /**
     * Возвращаем id сущности.
     *
     * @return int|string
     */
    public function getPrimaryKey()
    {
        // TODO: Implement getPrimaryKey() method.
    }

    /**
     * @return GroupInterface
     */
    public function getGroup1c()
    {
        // TODO: Implement getGroup1c() method.
    }

    /**
     * offers.xml > ПакетПредложений > Предложения > Предложение > Цены.
     *
     * Цена товара,
     * К $price можно обратиться как к массиву, чтобы получить список цен (Цены > Цена)
     * $price->type - тип цены (offers.xml > ПакетПредложений > ТипыЦен > ТипЦены)
     *
     * @param \Zenwalker\CommerceML\Model\Price $price
     *
     * @return void
     */
    public function setPrice1c($price)
    {
        // TODO: Implement setPrice1c() method.
    }

    /**
     * @param $types
     *
     * @return void
     */
    public static function createPriceTypes1c($types)
    {
        // TODO: Implement createPriceTypes1c() method.
    }

    /**
     * offers.xml > ПакетПредложений > Предложения > Предложение > ХарактеристикиТовара > ХарактеристикаТовара.
     *
     * Характеристики товара
     * $name - Наименование
     * $value - Значение
     *
     * @param \Zenwalker\CommerceML\Model\Simple $specification
     *
     * @return void
     */
    public function setSpecification1c($specification)
    {
        // TODO: Implement setSpecification1c() method.
    }
}
