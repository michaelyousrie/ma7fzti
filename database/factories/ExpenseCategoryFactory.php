<?php

use App\Models\User;
use Faker\Generator as Faker;
use App\Models\ExpenseCategory;

$factory->define(ExpenseCategory::class, function (Faker $faker) {
    return [
        'name'          => $faker->name,
        "description"   => $faker->sentence,
        "user_id"       => factory( User::class )->create()->id
    ];
});
