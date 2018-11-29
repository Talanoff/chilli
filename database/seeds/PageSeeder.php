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

        // Create contacts page
        App\Models\Page\Page::create([
            'title' => 'Контакты',
            'slug' => 'contacts',
            'body' => '<p>' . implode('</p><p>', $faker->sentences(2)) . '</p>',
        ]);

        // Create exchange page
        App\Models\Page\Page::create([
            'title' => 'Обмен и возврат',
            'slug' => 'exchange',
            'body' => '<p>' . implode('</p><p>', $faker->sentences(8)) . '</p>',
        ]);

        // Create privacy page
        App\Models\Page\Page::create([
            'title' => 'Политика конфиденциальности',
            'slug' => 'privacy',
            'body' => '<p>' . implode('</p><p>', $faker->sentences(8)) . '</p>',
        ]);

        // Create advantages page
        App\Models\Page\Page::create([
            'title' => 'Преимущества',
            'slug' => 'advantages',
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
