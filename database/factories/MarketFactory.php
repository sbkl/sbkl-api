<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use sbkl\SbklApi\Models\Market;
use sbkl\SbklApi\Models\Region;

$factory->define(Market::class, function (Faker $faker) {
    return [
        'region_id' => factory(Region::class),
        'name' => $faker->name,
    ];
});
