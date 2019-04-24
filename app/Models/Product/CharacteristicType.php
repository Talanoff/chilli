<?php

namespace App\Models\Product;

use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CharacteristicType extends Model
{
	use SluggableTrait;

	public static $TYPES = [
		'color' => 'Цвет',
	];

	protected $fillable = [
		'slug',
		'title',
		'1c_id',
	];

	/**
	 * @return HasMany
	 */
	public function characteristics(): HasMany
	{
		return $this->hasMany(Characteristic::class, 'type_id');
	}
}
