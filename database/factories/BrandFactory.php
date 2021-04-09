<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Brand;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    $name = $faker->name;
	$slug = Str::of($name)->slug('-');

    return [
        'name'  => $name,
        'slug'  => $slug,
        'icon' => 1,

    ];

});
