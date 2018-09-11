<?php

use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $title = implode(' ', $faker->words(rand(2, 4)));
            $type = array_keys(App\Models\Review\Review::$CATEGORIES)[rand(0, 1)];

            $review = App\Models\Review\Review::create([
                'slug' => str_slug($title),
                'title' => ucfirst($title),
                'type' => $type,
                'description' => $faker->text(),
                'video_url' => $type === 'article' ? null : 'https://youtu.be/vMwX2JGZC6w',
                'product_id' => $i,
                'is_published' => 1,
            ]);

            if (rand(0, 1)) {
                $review->addMediaFromUrl('http://placeimg.com/800/800/tech')
                       ->toMediaCollection('review');
            }
        }
    }
}
