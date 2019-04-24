<?php

namespace App\Traits;

use Cviebrock\EloquentSluggable\Sluggable;

trait SluggableTrait
{
	use Sluggable;

	/**
	 * Set key for model
	 * @return string
	 */
	public function getRouteKeyName(): string
	{
		return 'slug';
	}

	public function sluggable()
	{
		return [
			'slug' => [
				'source' => 'title',
				'unique' => true
			]
		];
	}
}
