<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use sbkl\SbklApi\Models\Company;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});
