<?php
/**
 * User: rchung
 * Date: 2014. 5. 31.
 * Time: 오전 11:04
 */

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $user = [
            'id' => '1',
            'email' => 'pearlc11@gmail.com',
            'password' => '$2y$10$pbRk30nzHY7YNT..S70meeYxUCT05cfUC0g8fEzYwfi33BNTkY.Ni',
            'activated' => 1,
            'activated_at' => '2014-05-31 02:58:50',
            'last_login' => '2014-05-31 02:58:55',
            'persist_code' => '$2y$10$Jv/K2a0kRXJljdkFm8qL1O.QGc0M/rGnGDsybU7fvH.aMyGqwVmyq',
            'nick_name' => '닉넴1',
            'created_at' => '2014-05-31 02:58:26',
            'updated_at' => '2014-05-31 02:58:55'
        ];
        User::create($user);
    }
} 
