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

         $this->call(ProductCategorySeeder::class);
         $this->call(ProductAttributeSeeder::class);
         $this->call(ProductSeeder::class);
    }
}
