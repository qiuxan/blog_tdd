<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        //
//        'title'=>$faker->sentence(4),
        'title'=>'fake title',
        'description'=>$faker->sentence(4),
//        'description'=>'fake description',
        'notes'=>'my note',
        'owner_id'=>factory(App\User::class)
    ];
});
