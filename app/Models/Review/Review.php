<?php

namespace App\Models\Review;

use App\Models\Comment\Comment;
use App\Models\Product\Product;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Review extends Model
{
    use Slugable;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'video_url',
        'product_id',
        'is_published',
    ];

    protected $with = [
        'product',
        'comment',
    ];

    protected $casts = [
        'product_id' => 'number',
        'is_published' => 'boolean',
    ];

    protected $appends = [
        'video_id'
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
    public function comment(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return mixed
     */
    public function getVideoIdAttribute()
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $this->video_url, $matches);
        return $matches[1];
    }
}
