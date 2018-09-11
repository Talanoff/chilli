<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 6; $i++) {
            $title = implode(' ', $faker->words(rand(2, 4)));

            $product = App\Models\Product\Product::create([
                'slug' => str_slug($title),
                'title' => ucfirst($title),
                'subtitle' => ucfirst(implode(' ', $faker->words(rand(3, 8)))),
                'category_id' => rand(1, 4),
                'description' => $faker->text(),
                'price' => rand(100, 1000),
                'discount' => null,
                'quantity' => rand(10, 100),
                'in_stock' => 0,
                'is_published' => 1,
            ]);

            factory(App\Models\Comment\Comment::class, rand(2, 5))->create([
                'commentable_type' => 'App\Models\Product\Product',
                'commentable_id' => $product->id,
                'status' => ['approved', 'agreement'][rand(0, 1)],
            ]);

            $u = rand(2, 5);
            while ($u > 1) {
                $product->ratings()->create([
                    'user_id' => $u,
                    'rate' => rand(1, 5),
                ]);
                $u--;
            }

            $product->addMediaFromUrl('http://placeimg.com/800/800/tech')
                    ->usingFileName('product.png')
                    ->toMediaCollection('product');
        }
    }
}
