<?php

namespace App\Models\Product;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rating extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rate'
    ];

    /**
     * @return HasMany
     */
    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return HasMany
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
