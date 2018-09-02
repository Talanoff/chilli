<?php

namespace App\Models\Product;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeType extends Model
{
    use Slugable;

    public static $TYPES = [
        'color' => 'Цвет',
        'material' => 'Материал',
        'weight' => 'Вес',
    ];

    protected $fillable = [
        'slug',
        'title',
    ];

    /**
     * @return HasMany
     */
    public function attribute(): HasMany
    {
        return $this->hasMany(Attribute::class, 'type_id');
    }
}
