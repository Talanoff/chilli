<?php

namespace App\Models\Product;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'email',
        'status',
    ];

    public static $STATUSES = [
        'processing' => 'В обработке',
        'finished' => 'Завершен',
        'declined' => 'Отклонен',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        self::addGlobalScope('ordered', function () {
            self::orderByRaw("FIELD(status , 'processing') DESC")
                ->orderByRaw("FIELD(status , 'finished') DESC");
        });
    }
}
