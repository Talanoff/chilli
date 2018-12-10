<?php

namespace App\Models\Product;

use App\Http\Resources\ImageResource;
use App\Models\Comment\Comment;
use App\Models\Meta\Meta;
use App\Models\Order\Checkout;
use App\Models\Review\Review;
use App\Traits\Sluggable;
use Bigperson\Exchange1C\Interfaces\GroupInterface;
use Bigperson\Exchange1C\Interfaces\OfferInterface;
use Bigperson\Exchange1C\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\{HasMedia\HasMedia, HasMedia\HasMediaTrait, Models\Media};
use Zenwalker\CommerceML\Model\PropertyCollection;

class Product extends Model implements HasMedia, ProductInterface
{
    use HasMediaTrait;
    use Sluggable;

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'description',
        'price',
        'discount',
        'quantity',
        'in_stock',
        'category_id',
        'brand_id',
        'is_published',
        'rating',
        'tag',
    ];

    protected $casts = [
        'price' => 'float',
        'discount' => 'float',
        'quantity' => 'number',
        'in_stock' => 'boolean',
        'rating' => 'float',
        'is_published' => 'boolean',
    ];

    protected $appends = [
        'sku',
        'gallery',
        'gallery_preview',
        'thumbnail',
        'computed_price',
        'stars',
        'colors',
    ];

    protected $with = [
        'ratings',
        'brand',
    ];

    public static $TAGS = [
        'newest' => 'Новинка',
        'popular' => 'Популярное',
        'special_offer' => 'Специальное предложение',
        'absolute_hit' => 'Абсолютный хит',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function characteristics(): BelongsToMany
    {
        return $this->belongsToMany(Characteristic::class);
    }

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return HasOne
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        $comments = $this->morphMany(Comment::class, 'commentable');

        if (app('router')->currentRouteNamed('app.*')) {
            $comments = $comments->whereStatus('approved');
        }

        return $comments;
    }

    /**
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * @return HasMany
     */
    public function kits(): HasMany
    {
        return $this->hasMany(Kit::class);
    }

    /**
     * @return HasMany
     */
    public function checkouts(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    /**
     * @return HasMany
     */
    public function favourites(): HasMany
    {
        return $this->hasMany(Favourite::class);
    }

    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    /**
     * @return BelongsToMany
     */
    public function series(): BelongsToMany
    {
        return $this->belongsToMany(Series::class);
    }

    /**
     * @return HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * @return mixed
     */
    public function getRecommendedAttribute()
    {
        return $this->where('id', '!=', $this->id)->inRandomOrder()->take(4)->get();
    }

    /**
     * @return string
     */
    public function getSkuAttribute(): string
    {
        return sprintf("%05d", $this->id + 1000);
    }

    /**
     * @return float|int|mixed
     */
    public function getComputedPriceAttribute()
    {
        $price = $this->price;

        if ($this->in_stock && $this->discount) {
            $price = number_format($this->price - ($this->price * ($this->discount / 100)), 2);
        }

        return $price;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getGalleryAttribute()
    {
        return $this->getMedia('product')->map(function ($file) {
            return $file->getUrl('large');
        });
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getGalleryPreviewAttribute()
    {
        return ImageResource::collection($this->getMedia('product'));
    }

    /**
     * @return string
     */
    public function getThumbnailAttribute()
    {
        return $this->getFirstMediaUrl('product', 'thumb');
    }

    /**
     * @return string
     */
    public function getStarsAttribute(): string
    {
        $rate = $this->rating ?? $this->ratings()->avg('rate');
        return round($rate);
    }

    /**
     * @return mixed
     */
    public function getColorsAttribute()
    {
        return $this->characteristics()->whereType('color')->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLeaders($query)
    {
        return $query->withCount('checkouts')
                     ->orderBy('checkouts_count', 'desc');
    }

    /**
     * Boot media for products
     */
    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('product')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, 200, 200)
                    ->width(200)
                    ->height(200);

                $this
                    ->addMediaConversion('medium')
                    ->width(600)
                    ->height(600);

                $this
                    ->addMediaConversion('large')
                    ->width(1200)
                    ->height(1200);
            });
    }

    /**
     * @return void
     * @throws \InvalidArgumentException
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = str_slug($model->title);
        });

        if (!app('router')->currentRouteNamed('admin.*')) {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('is_published', 1);
            });
        }
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
     * Получение уникального идентификатора продукта в рамках БД сайта.
     *
     * @return int|string
     */
    public function getPrimaryKey()
    {
        // TODO: Implement getPrimaryKey() method.
    }

    /**
     * Если по каким то причинам файлы import.xml или offers.xml были модифицированы и какие то данные
     * не попадают в парсер, в самом конце вызывается данный метод, в $product и $cml можно получить все
     * возможные данные для ручного парсинга.
     *
     * @param \Zenwalker\CommerceML\CommerceML $cml
     * @param \Zenwalker\CommerceML\Model\Product $product
     *
     * @return void
     */
    public function setRaw1cData($cml, $product)
    {
        // TODO: Implement setRaw1cData() method.
    }

    /**
     * Установка реквизитов, (import.xml > Каталог > Товары > Товар > ЗначенияРеквизитов > ЗначениеРеквизита)
     * $name - Наименование
     * $value - Значение.
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function setRequisite1c($name, $value)
    {
        // TODO: Implement setRequisite1c() method.
    }

    /**
     * Предпологается, что дерево групп у Вас уже создано (\carono\exchange1c\interfaces\GroupInterface::createTree1c).
     *
     * @param \Zenwalker\CommerceML\Model\Group $group
     *
     * @return mixed
     */
    public function setGroup1c($group)
    {
        // TODO: Implement setGroup1c() method.
    }

    /**
     * import.xml > Классификатор > Свойства > Свойство
     * $property - Свойство товара.
     *
     * import.xml > Классификатор > Свойства > Свойство > Значение
     * $property->value - Разыменованное значение (string)
     *
     * import.xml > Классификатор > Свойства > Свойство > ВариантыЗначений > Справочник
     * $property->getValueModel() - Данные по значению, Ид значения, и т.д
     *
     * @param \Zenwalker\CommerceML\Model\Property $property
     *
     * @return void
     */
    public function setProperty1c($property)
    {
        // TODO: Implement setProperty1c() method.
    }

    /**
     * @param string $path
     * @param string $caption
     *
     * @return void
     */
    public function addImage1c($path, $caption)
    {
        // TODO: Implement addImage1c() method.
    }

    /**
     * @return GroupInterface
     */
    public function getGroup1c()
    {
        // TODO: Implement getGroup1c() method.
    }

    /**
     * Создание всех свойств продутка
     * import.xml > Классификатор > Свойства.
     *
     * $properties[]->availableValues - список доступных значений, для этого свойства
     * import.xml > Классификатор > Свойства > Свойство > ВариантыЗначений > Справочник
     *
     * @param PropertyCollection $properties
     *
     * @return mixed
     */
    public static function createProperties1c($properties)
    {
        // TODO: Implement createProperties1c() method.
    }

    /**
     * @param \Zenwalker\CommerceML\Model\Offer $offer
     *
     * @return OfferInterface
     */
    public function getOffer1c($offer)
    {
        // TODO: Implement getOffer1c() method.
    }

    /**
     * @param \Zenwalker\CommerceML\Model\Product $product
     *
     * @return self
     */
    public static function createModel1c($product)
    {
        // TODO: Implement createModel1c() method.
    }

    /**
     * @param string $id
     *
     * @return ProductInterface|null
     */
    public static function findProductBy1c(string $id): ?self
    {
        // TODO: Implement findProductBy1c() method.
    }
}
