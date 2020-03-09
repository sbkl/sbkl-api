<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Market;
use App\Region;
use Faker\Generator as Faker;

$factory->define(Market::class, function (Faker $faker) {
    return [
        'region_id' => factory(Region::class),
        'name' => $faker->name,
    ];
});
