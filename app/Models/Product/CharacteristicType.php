<?php

namespace App\Models\Product;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CharacteristicType extends Model
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
    public function characteristics(): HasMany
    {
        return $this->hasMany(Characteristic::class, 'type_id');
    }
}
