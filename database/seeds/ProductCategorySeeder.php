<?php

use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
            'Бамперы',
            'Чехлы',
            'Защитные стекла',
        ]);

        $categories->map(function ($category) {
            \App\Models\Product\Category::create([
                'slug' => str_slug($category),
                'title' => $category,
            ]);
        });
    }
}
