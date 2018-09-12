<?php

namespace App\Models\Product;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Favourite extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return mixed
     */
    public static function favourites()
    {
        $user = Auth::check() ? Auth::user()->id : session()->getId();

        return self::whereUserId($user)->get();
    }
}
