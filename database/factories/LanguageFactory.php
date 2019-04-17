<?php

use Faker\Generator as Faker;
use App\Models\Language;
use Illuminate\Support\Str;

$factory->define(Language::class, function (Faker $faker) {

    $code = Str::random(2);

    while ( Language::where('code', $code)->first() != null ) {
        $code = Str::random(2);
    }

    return [
        "code"  => $code,
        "name"  => Str::random(5),
    ];
});
