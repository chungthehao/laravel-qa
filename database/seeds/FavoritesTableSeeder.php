<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Xoa du lieu cua bang favorites truoc khi tao du lieu mau
        // Nham dam bao rang:
        // Khong co 2 records nao trung nhau user_id & question_id
        \DB::table('favorites')->delete();

        //--------------------------------------------------------

        # Lay 1 mang cac id cua user
        $users = User::pluck('id')->all();
        # Dem tong so cac user
        $numberOfUsers = count($users);

        # To make the question favorited by at least 1 user
        foreach (Question::all() as $question) {
            $tmp_users = $users; // Chi co cach 2 can thoi
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                /* Cach 2 */
                # Lay ngau nhien 1 user id trong $tmp_users
                $randId = $tmp_users[array_rand($tmp_users)];

                # Cho user do favorite question nay
                $question->favorites()->attach($randId);

                # Loai bo user da favorite question nay ra, de khi chon ngau nhien
                // thang user khac se khong bi trung lai thang nay
                unset($tmp_users[array_search($randId, $tmp_users)]);

                //--------------------------------------------------------------

                /* Cach 1 */
                # Question nao cung co thang user co id=$users[0] favorite :))
                //$userId = $users[$i];
                //$question->favorites()->attach($userId);
            }
        }
    }
}
