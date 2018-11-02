<?php

namespace App\Models\User;

use App\Models\Comment\Comment;
use App\Models\Order\Checkout;
use App\Models\Order\Order;
use App\Models\Product\Notification;
use App\Models\Product\Product;
use App\Models\Product\Rating;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Array of dates that could be formatted by Carbon
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'birthday',
    ];

    protected $appends = [
        'formatted_phone',
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
     * @return HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
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
                    ->where('status', '!=', 'in_progress');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)
                    ->where('status', '!=', 'in_progress');
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function productRating(Product $product)
    {
        return optional($this->ratings()->whereProductId($product->id)->first())->rate;
    }

    public static function define()
    {
        return Auth::check() ? Auth::user()->getKey() : session()->getId();
    }

    /**
     * @return string
     */
    public function getFormattedPhoneAttribute()
    {
        preg_match('/^\+([0-9]{1,3})([0-9]{3})([0-9]{3})([0-9]{2})([0-9]{2})/', $this->phone, $matches);
        return "+{$matches[1]} ({$matches[2]}) {$matches[3]}-{$matches[4]}-{$matches[5]}";
    }
}
