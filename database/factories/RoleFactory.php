<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
$factory->state(Role::class, 'Admin', function (Faker $faker) {
    return [
        'name' => 'Admin',
    ];
});
$factory->state(Role::class, 'OSL', function (Faker $faker) {
    return [
        'name' => 'OSL',
    ];
});
$factory->state(Role::class, 'BOH', function (Faker $faker) {
    return [
        'name' => 'BOH',
    ];
});
$factory->state(Role::class, 'FOH', function (Faker $faker) {
    return [
        'name' => 'FOH',
    ];
});
