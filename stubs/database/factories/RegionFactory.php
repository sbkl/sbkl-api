<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Region;
use Faker\Generator as Faker;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'company_id' => factory(Company::class),
        'name' => $faker->country,
    ];
});
