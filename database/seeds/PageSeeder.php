<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        // Create about page
        //        App\Models\Page\Page::create([
        //            'title' => 'О нас',
        //            'slug' => 'about',
        //            'body' => '<p>' . implode('</p><p>', $faker->sentences(4)) . '</p>',
        //        ]);

        // Create contacts page
        App\Models\Page\Page::create([
            'title' => 'Контакты',
            'slug' => 'contacts',
            'body' => '<p>' . implode('</p><p>', $faker->sentences(2)) . '</p>',
        ]);

        // Create warranty page
        App\Models\Page\Page::create([
            'title' => 'Гарантии',
            'slug' => 'warranty',
            'body' => '<p>' . implode('</p><p>', $faker->sentences(8)) . '</p>',
        ]);

        // Create delivery page
        App\Models\Page\Page::create([
            'title' => 'Оплата и доставка',
            'slug' => 'delivery',
            'body' => '<p>' . implode('</p><p>', $faker->sentences(8)) . '</p>',
        ]);
    }
}
