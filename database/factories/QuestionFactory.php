<?php

use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        // Xóa dấu chấm mặc định ở cuối câu
        'title' => rtrim($faker->sentence(rand(5, 10)), '.'),
        // param2=true để trả về là 1 string, chứ ko phải là 1 array
        'body' => $faker->paragraphs(rand(3, 7), true),

        'views' => rand(0, 10),

        # Không phản ánh đúng số lượng answer thực tế
        # Đã dùng eloquent event để cập nhật cx, trong Answer Model
        // 'answers_count' => rand(0, 10),

        'votes' => rand(-3, 10),
    ];
});
