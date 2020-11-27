<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Todo::class, function (Faker $faker) {

    // 随机取一个月以内的时间
    $time = $faker->dateTimeThisMonth();

    return [
        'title' => $faker->sentence(),
        'desc' => $faker->sentence(),
        'created_at' => $time,
        'updated_at' => $time,
        'user_id' => rand(1, 10),
    ];
});
