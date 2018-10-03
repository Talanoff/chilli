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
        $this->call(AdminUserSeeder::class);
        $this->call(RolesSeeder::class);

        $this->call(ProductCharacteristicSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(PageSeeder::class);

        if (config('app.env') === 'local') {
            $this->call(ProductCategorySeeder::class);
            $this->call(ProductSeeder::class);
            $this->call(ReviewSeeder::class);
        }
    }
}
