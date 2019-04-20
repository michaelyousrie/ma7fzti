<?php

use App\Models\User;
use Faker\Generator as Faker;
use App\Models\IncomeCategory;

$factory->define(IncomeCategory::class, function (Faker $faker) {
    return [
        'name'          => $faker->name,
        "description"   => $faker->sentence,
        "user_id"       => function() { factory( User::class )->create()->id; }
    ];
});
