<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use sbkl\SbklApi\Models\Company;
use sbkl\SbklApi\Models\Region;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'company_id' => factory(Company::class),
        'name' => $faker->country,
    ];
});
