<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'country_id' => \App\Country::all()->random()->id,
    ];
});
