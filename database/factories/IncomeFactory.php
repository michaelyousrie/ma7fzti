<?php

use App\Models\User;
use App\Models\Income;
use Faker\Generator as Faker;
use App\Models\IncomeCategory;

$factory->define(Income::class, function (Faker $faker) {
    return [
        'user_id'       => function() { return factory( User::class )->create()->id; },
        "amount"        => function() { return round(random_int(10, 100)/random_int(1, 9), 2); },
        "category_id"   => function() { return factory( IncomeCategory::class )->create()->id; },
        "description"   => $faker->sentence
    ];
});
