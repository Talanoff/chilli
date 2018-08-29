<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    protected $fillable = [
        'value',
        'type',
        'type_id',
    ];

    protected $with = [
        'product',
        'type',
    ];

    public static $TYPES = [
        'text' => 'Текст',
        'color' => 'Цвет',
        'image' => 'Изображение',
    ];

    /**
     * @return BelongsToMany
     */
    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(AttributeType::class);
    }
}
