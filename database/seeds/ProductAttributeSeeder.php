<?php

use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        collect(\App\Models\Product\AttributeType::$TYPES)->map(function ($type, $index) {
            \App\Models\Product\AttributeType::create([
                'slug' => str_slug($index),
                'title' => ucfirst($type),
            ]);
        });

        for ($i = 0; $i < 60; $i++) {
            $type = rand(1, count(\App\Models\Product\AttributeType::$TYPES));

            \App\Models\Product\Attribute::create([
                'type_id' => $type,
                'type' => $type > 1 ? 'text' : 'color',
                'value' => $type > 1 ? ucfirst(implode(' ', $faker->words(rand(1, 3)))) : $faker->hexcolor,
            ]);
        }
    }
}
