<?php

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Language;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'currency'  => "EGP",
        "language_code" => function() { return factory( Language::class )->create()->code; },
        'remember_token' => Str::random(10),
        "api_token"     => Str::random(20),
        "app_version"   => "1.0"
    ];
});
