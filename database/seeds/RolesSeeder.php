<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    protected $roles = [
        'administrator' => 'Administrator',
        'customer' => 'Customer',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $key => $name) {
            \App\Models\User\Role::create([
                'name' => $key,
                'display_name' => $name
            ]);
        }
    }
}
