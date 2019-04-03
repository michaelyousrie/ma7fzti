<?php

use Faker\Generator as Faker;
use App\Models\Language;
use Illuminate\Support\Str;

$factory->define(Language::class, function (Faker $faker) {
    return [
        "code"  => Str::random(2),
        "name"  => Str::random(5),
    ];
});
