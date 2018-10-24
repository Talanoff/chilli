<?php

use Illuminate\Database\Seeder;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (\App\Models\Product\Brand::get() as $brand) {
            for ($i = 0; $i <= rand(10, 15); $i++) {
                \App\Models\Product\Series::create([
                    'title' => ucfirst($faker->words(rand(2, 5), true)),
                    'brand_id' => $brand->id,
                ]);
            }
        }
    }
}
