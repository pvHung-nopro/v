<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $name = $faker->name;
	$slug = Str::of($name)->slug('-');

    return [
        'name'  => $name,
        'slug'  => $slug,
        'price' => $faker->randomNumber(4),
        'qty' => $faker->randomNumber(4),
        'category_id'=>array_rand([1, 10]),
        'sub_category_id'=>array_rand([1, 10]),
        'brand_id'=>array_rand([1, 10]),
        'image' => 'images/home/recommend2.jpg',
    ];
});
