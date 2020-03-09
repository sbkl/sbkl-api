<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use sbkl\SbklApi\Models\Market;
use sbkl\SbklApi\Models\Store;

$factory->define(Store::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'market_id' => factory(Market::class),
        'name' => $faker->name,
        'channel' => 'Mainline',
    ];
});
