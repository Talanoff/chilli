<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    protected $roles = [
        'administrator' => 'Администратор',
        'customer' => 'Покупатель',
		'import' => '1C пользователь'
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
