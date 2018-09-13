<?php

namespace App\Models\Review;

use App\Models\Comment\Comment;
use App\Models\Meta\Meta;
use App\Models\Product\Product;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Review extends Model implements HasMedia
{
    use Slugable;
    use HasMediaTrait;

    public static $CATEGORIES = [
        'video' => 'Видеообзор',
        'article' => 'Статья',
    ];

    protected $fillable = [
        'slug',
        'title',
        'description',
        'video_url',
        'product_id',
        'type',
        'is_published',
    ];

    protected $with = [
        'product',
        'comments',
    ];

    protected $casts = [
        'product_id' => 'number',
        'is_published' => 'boolean',
    ];

    protected $appends = [
        'video_id',
        'thumbnail',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
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
    public function getVideoIdAttribute()
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",
            $this->video_url, $matches);
        return $matches[1];
    }

    public function getThumbnailAttribute()
    {
        $thumb = $this->hasMedia('review') ? $this->getFirstMediaUrl('review', 'medium') : asset('images/no-image.png');

        if ($this->video_url && !$this->hasMedia('review')) {
            $thumb = 'https://img.youtube.com/vi/' . $this->getVideoIdAttribute() . '/sddefault.jpg';
        }

        return $thumb;
    }

    public function getLargeImageAttribute()
    {
        $thumb = $this->hasMedia('review') ? $this->getFirstMediaUrl('review', 'large') : asset('images/no-image.png');

        if ($this->video_url && !$this->hasMedia('review')) {
            $thumb = 'https://img.youtube.com/vi/' . $this->getVideoIdAttribute() . '/maxresdefault.jpg';
        }

        return $thumb;
    }

    /**
     * Boot media for products
     */
    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('review')
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
