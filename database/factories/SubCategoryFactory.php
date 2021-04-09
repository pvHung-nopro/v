<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SubCategory;
use Faker\Generator as Faker;

$factory->define(SubCategory::class, function (Faker $faker) {
    $name = $faker->name;
	$slug = Str::of($name)->slug('-');
    return [
        'name'  => $name,
        'slug'  => $slug,
        'icon' => 1,
        'category_id'=>array_rand([1, 10]),
    ];
});
