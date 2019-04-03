<?php

use App\Models\User;
use Faker\Generator as Faker;
use App\Models\ExpenseCategory;
use App\Models\Expense;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'user_id'       => factory( User::class )->create()->id,
        "amount"        => random_int(10, 100),
        "category_id"   => factory( ExpenseCategory::class )->create()->id,
        "description"   => $faker->sentence
    ];
});
