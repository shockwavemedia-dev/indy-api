<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NotificationUsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('notification_users')->delete();

        \DB::table('notification_users')->insert([
            0 => [
                'id' => 1,
                'notification_id' => 1,
                'status' => 'new',
                'title' => null,
                'user_id' => 3,
            ],
            1 => [
                'id' => 2,
                'notification_id' => 2,
                'status' => 'new',
                'title' => null,
                'user_id' => 4,
            ],
            2 => [
                'id' => 3,
                'notification_id' => 3,
                'status' => 'new',
                'title' => null,
                'user_id' => 6,
            ],
            3 => [
                'id' => 4,
                'notification_id' => 4,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            4 => [
                'id' => 5,
                'notification_id' => 5,
                'status' => 'new',
                'title' => null,
                'user_id' => 3,
            ],
            5 => [
                'id' => 6,
                'notification_id' => 6,
                'status' => 'new',
                'title' => null,
                'user_id' => 4,
            ],
            6 => [
                'id' => 7,
                'notification_id' => 7,
                'status' => 'new',
                'title' => null,
                'user_id' => 6,
            ],
            7 => [
                'id' => 8,
                'notification_id' => 8,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            8 => [
                'id' => 9,
                'notification_id' => 9,
                'status' => 'new',
                'title' => null,
                'user_id' => 4,
            ],
            9 => [
                'id' => 10,
                'notification_id' => 10,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            10 => [
                'id' => 11,
                'notification_id' => 11,
                'status' => 'new',
                'title' => null,
                'user_id' => 6,
            ],
            11 => [
                'id' => 12,
                'notification_id' => 12,
                'status' => 'new',
                'title' => null,
                'user_id' => 3,
            ],
            12 => [
                'id' => 13,
                'notification_id' => 13,
                'status' => 'new',
                'title' => null,
                'user_id' => 4,
            ],
            13 => [
                'id' => 14,
                'notification_id' => 14,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            14 => [
                'id' => 15,
                'notification_id' => 15,
                'status' => 'new',
                'title' => null,
                'user_id' => 3,
            ],
            15 => [
                'id' => 16,
                'notification_id' => 16,
                'status' => 'new',
                'title' => null,
                'user_id' => 6,
            ],
            16 => [
                'id' => 17,
                'notification_id' => 17,
                'status' => 'new',
                'title' => null,
                'user_id' => 4,
            ],
            17 => [
                'id' => 18,
                'notification_id' => 18,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            18 => [
                'id' => 19,
                'notification_id' => 19,
                'status' => 'new',
                'title' => null,
                'user_id' => 3,
            ],
            19 => [
                'id' => 20,
                'notification_id' => 20,
                'status' => 'new',
                'title' => null,
                'user_id' => 4,
            ],
            20 => [
                'id' => 21,
                'notification_id' => 21,
                'status' => 'new',
                'title' => null,
                'user_id' => 6,
            ],
            21 => [
                'id' => 22,
                'notification_id' => 22,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            22 => [
                'id' => 23,
                'notification_id' => 23,
                'status' => 'new',
                'title' => null,
                'user_id' => 3,
            ],
            23 => [
                'id' => 24,
                'notification_id' => 24,
                'status' => 'new',
                'title' => null,
                'user_id' => 4,
            ],
            24 => [
                'id' => 25,
                'notification_id' => 25,
                'status' => 'new',
                'title' => null,
                'user_id' => 6,
            ],
            25 => [
                'id' => 26,
                'notification_id' => 26,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            26 => [
                'id' => 27,
                'notification_id' => 27,
                'status' => 'deleted',
                'title' => null,
                'user_id' => 7,
            ],
            27 => [
                'id' => 28,
                'notification_id' => 28,
                'status' => 'deleted',
                'title' => null,
                'user_id' => 7,
            ],
            28 => [
                'id' => 29,
                'notification_id' => 29,
                'status' => 'new',
                'title' => null,
                'user_id' => 7,
            ],
            29 => [
                'id' => 30,
                'notification_id' => 30,
                'status' => 'new',
                'title' => null,
                'user_id' => 7,
            ],
            30 => [
                'id' => 31,
                'notification_id' => 31,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            31 => [
                'id' => 32,
                'notification_id' => 32,
                'status' => 'new',
                'title' => null,
                'user_id' => 7,
            ],
            32 => [
                'id' => 33,
                'notification_id' => 33,
                'status' => 'new',
                'title' => null,
                'user_id' => 5,
            ],
            33 => [
                'id' => 34,
                'notification_id' => 34,
                'status' => 'new',
                'title' => null,
                'user_id' => 7,
            ],
            34 => [
                'id' => 35,
                'notification_id' => 35,
                'status' => 'new',
                'title' => null,
                'user_id' => 7,
            ],
            35 => [
                'id' => 36,
                'notification_id' => 36,
                'status' => 'new',
                'title' => null,
                'user_id' => 4,
            ],
        ]);
    }
}
