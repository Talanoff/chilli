<?php

namespace App\Models\Product;

use App\Http\Resources\ImageResource;
use App\Models\Comment\Comment;
use App\Models\Meta\Meta;
use App\Models\Order\Checkout;
use App\Models\Review\Review;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\{HasMedia\HasMedia, HasMedia\HasMediaTrait, Models\Media};

class Product extends Model implements HasMedia
{
    use HasMediaTrait;
    use Slugable;

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
    public function checkout(): HasMany
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

    public function scopeLeaders($query)
    {

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
        if (!app('router')->currentRouteNamed('admin.*')) {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('is_published', 1);
            });
        }
    }
}
