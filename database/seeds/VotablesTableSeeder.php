<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Reset votables table before insert some records
        \DB::table('votables')->delete();

        #
        $users = User::all()->all();
        $numberOfUsers = count($users);
        $votes = [-1, 1];

        # Tao du lieu mau cho bang trung gian (votables) phan question
        // Dong thoi dong bo voi votes_count trong bang questions
        foreach (Question::all() as $question) {
            $tmp_users = $users; // Chi co cach 2 can thoi
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                # Lay ngau nhien 1 user instance trong $tmp_users
                $randKey = array_rand($tmp_users);
                $randUser = $tmp_users[$randKey];

                # Cho user do vote question nay
                $randUser->voteTheQuestion($question, $votes[rand(0,1)]);

                # Loai bo user da vote question nay ra, de khi chon ngau nhien
                // thang user khac se khong bi trung lai thang nay
                unset($tmp_users[$randKey]);
            }
        }

        # Tao du lieu mau cho bang trung gian (votables) phan answer
        // Dong thoi dong bo voi votes_count trong bang answers
        foreach (Answer::all() as $answer) {
            $tmp_users = $users; // Chi co cach 2 can thoi
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                # Lay ngau nhien 1 user instance trong $tmp_users
                $randKey = array_rand($tmp_users);
                $randUser = $tmp_users[$randKey];

                # Cho user do vote answer nay
                $randUser->voteTheAnswer($answer, $votes[rand(0,1)]);

                # Loai bo user da vote answer nay ra, de khi chon ngau nhien
                // thang user khac se khong bi trung lai thang nay
                unset($tmp_users[$randKey]);
            }
        }
        
    }
}
