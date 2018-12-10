<?php

namespace App\Models\Product;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use Sluggable;

    protected $fillable = [
        'slug',
        'title',
    ];

    protected $with = [
        'product'
    ];

    /**
     * @return HasMany
     */
    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
