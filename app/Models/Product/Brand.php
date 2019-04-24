<?php

namespace App\Models\Product;

use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\{HasMedia\HasMedia, HasMedia\HasMediaTrait, Models\Media};

class Brand extends Model implements HasMedia
{
	use SluggableTrait, HasMediaTrait;

	protected $fillable = [
		'title',
		'slug',
		'order',
		'1c_id',
	];

	/**
	 * @return HasMany
	 */
	public function products(): HasMany
	{
		return $this->hasMany(Product::class);
	}

	/**
	 * @return HasMany
	 */
	public function series(): HasMany
	{
		return $this->hasMany(Series::class);
	}

	/**
	 * Boot media for products
	 */
	public function registerMediaCollections()
	{
		$this
			->addMediaCollection('brand')
			->registerMediaConversions(function (Media $media) {
				$this
					->addMediaConversion('thumb')
					->fit(Manipulations::FIT_CROP, 200, 200)
					->width(200)
					->height(200);
			});
	}
}
