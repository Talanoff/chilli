<?php

namespace App\Models\User;

use App\Models\Order\Checkout;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Product\Rating;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'birthday',
    ];

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role): bool
    {
        return $this->role->name === $role;
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
    public function checkout(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    /**
     * @return mixed
     */
    public function cart()
    {
        return $this->checkout()
                    ->whereStatus('in_progress');
    }

    /**
     * @return mixed
     */
    public function processedCheckout()
    {
        return $this->checkout()
                    ->whereStatus('processing');
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class)
                    ->whereStatus('processing');
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function productRating(Product $product)
    {
        return optional($this->ratings()->whereProductId($product->id)->first())->rate;
    }
}
