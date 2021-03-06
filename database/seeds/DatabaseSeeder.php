<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUserSeeder::class,
            RolesSeeder::class,
            BrandsTableSeeder::class,
            SettingsSeeder::class,
            PageSeeder::class,
			ProductCharacteristicSeeder::class,
        ]);

        if (config('app.env') === 'local') {
            $this->call([
                SeriesTableSeeder::class,
                ProductCategorySeeder::class,
                ProductSeeder::class,
                ReviewSeeder::class,
            ]);
        }
    }
}
