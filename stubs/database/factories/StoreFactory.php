<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Market;
use App\Store;
use Faker\Generator as Faker;

$factory->define(Store::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'market_id' => factory(Market::class),
        'name' => $faker->name,
        'channel' => 'Mainline',
    ];
});
