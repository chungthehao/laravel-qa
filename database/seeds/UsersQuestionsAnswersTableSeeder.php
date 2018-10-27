<?php

use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Xoa du lieu trong cac bang answers, questions, users
        // Luu y: phai xoa theo thu tu nguoc lai voi luc tao ra
        // Luc tao: user -> question -> answer
        // vay luc xoa: answer -> question-> user
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();
        \DB::table('users')->delete();

        //----------------------------------------------------------------------

        # Đúng cho riêng users
        //factory(\App\User::class, 3)->create();

        /* CÁCH SAI: Vì bảng questions có khóa ngoại là user_id (khai báo trong migration) */
        //factory(\App\Question::class, 10)->create();

        /* CÁCH ĐÚNG: users và questions cùng 1 lúc */
        factory(\App\User::class, 3)->create()->each(function($u) { // $u: đại diện User instance
            $u->questions() // Mối quan hệ trong User model
            ->saveMany(
            // Không dùng create(), vì create() sẽ lưu thẳng vào database
            // Còn make() tạo ra đối tượng và lưu trong bộ nhớ, rồi lưu lại bằng saveMany()
                factory(App\Question::class, rand(1, 5))->make()
            )
                ->each(function ($q) { // đại diện Question instance
                    $q->answers() // Mối quan hệ trong Question model
                    ->saveMany(
                        factory(App\Answer::class, rand(0, 5))->make()
                    );
                });
        });
    }
}
