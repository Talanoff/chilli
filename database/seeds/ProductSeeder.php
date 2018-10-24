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

        for ($i = 0; $i < 20; $i++) {
            $title = implode(' ', $faker->words(rand(2, 4)));

            /** @var App\Models\Product\Product $product */
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
                'brand_id' => \App\Models\Product\Brand::inRandomOrder()->take(1)->first()->id,
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

            $product->addMediaFromUrl('https://store.storeimages.cdn-apple.com/4981/as-images.apple.com/is/image/AppleInc/aos/published/images/M/QG/MQGX2/MQGX2?wid=445&hei=445&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1516399367562')->toMediaCollection('product');

            $product->series()->attach(\App\Models\Product\Series::where('brand_id', $product->brand_id)->take(1)->inRandomOrder()->pluck('id')->toArray());
        }
    }
}
