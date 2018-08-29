<?php

namespace App\Models\Product;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use Slugable;

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
