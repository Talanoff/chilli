<?php

use Illuminate\Database\Seeder;

class ProductCharacteristicSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (\App\Models\Product\CharacteristicType::$TYPES as $slug => $type) {
			\App\Models\Product\CharacteristicType::create([
				'slug' => $slug,
				'title' => ucfirst($type)
			]);
		}
	}
}
