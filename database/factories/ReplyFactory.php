<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Reply::class, function (Faker $faker) {

	$time = $faker->dateTimeThisMonth();

	// 随机取一个月以内的时间
    return [

        'content'=>$faker->sentence,
        'created_at'=>$time,
        'updated_at'=>$time,

    ];
});
