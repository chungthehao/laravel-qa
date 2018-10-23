<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraphs(rand(3, 5), true),

        # App\User::pluck('id') trả về 1 collection các id
        # Mình có thể lấy 1 item ngẫu nhiên từ collection bằng
        // cách gọi method random()
        # Cách khác: array_random(App\User::pluck('id')->all())
        'user_id' => App\User::pluck('id')->random(),

        'votes_count' => rand(0, 5),
    ];
});
