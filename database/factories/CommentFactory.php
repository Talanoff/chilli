<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment\Comment::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence,
        'user_id' => function() {
            $user = App\Models\User\User::find(rand(1, 5));

            if (isset($user)) {
                return $user->id;
            } else {
                return factory(App\Models\User\User::class)->create()->id;
            }
        },
        'status' => 'agreement'
    ];
});
