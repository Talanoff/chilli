<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Characteristic extends Model
{
    protected $fillable = [
        'value',
        'type',
        'type_id',
    ];

    protected $with = [
        'products',
        'type',
    ];

    public static $TYPES = [
        'text' => 'Текст',
        'color' => 'Цвет',
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(CharacteristicType::class);
    }
}
