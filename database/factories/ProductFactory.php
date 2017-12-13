<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'pName'=>$faker->sentence(),
        'oPrice'=>$faker->numberBetween(8,888),
        'nPrice'=>$faker->numberBetween(8,888),
        'stock'=>$faker->numberBetween(1,2000),
        'description'=>$faker->paragraph(),
        'photo'=>'/images/1.jpg',
        'categoryId'=>factory(\App\ProductCategory::class)->create()->id


    ];
});
