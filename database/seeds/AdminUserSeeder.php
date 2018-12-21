<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        \App\Models\User\User::create([
            'name' => 'Admin Adminoff',
            'email' => 'admin@chilli.com.ua',
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
            'role_id' => 1,
        ]);

        /* 1C user */
		\App\Models\User\User::create([
			'name' => '1C Exchange',
			'email' => 'exchange@chilli.com.ua',
			'password' => bcrypt('1csync'),
			'remember_token' => str_random(10),
			'role_id' => 3,
		]);
    }
}
