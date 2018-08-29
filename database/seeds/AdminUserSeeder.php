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
            'email' => 'admin@app.com',
            'phone' => $faker->e164PhoneNumber,
            'birthday' => $faker->date('Y-m-d', Carbon\Carbon::now()->subYear(30)),
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
            'role_id' => 1,
        ]);
    }
}
