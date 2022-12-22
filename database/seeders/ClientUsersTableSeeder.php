<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientUsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('client_users')->delete();

        \DB::table('client_users')->insert([
            0 => [
                'client_id' => 1,
                'client_role' => 'marketing manager',
                'created_at' => '2022-12-19 00:04:22',
                'id' => 1,
                'updated_at' => '2022-12-19 00:04:22',
            ],
            1 => [
                'client_id' => 1,
                'client_role' => 'marketing manager',
                'created_at' => '2022-12-19 03:15:47',
                'id' => 2,
                'updated_at' => '2022-12-19 03:15:47',
            ],
            2 => [
                'client_id' => 1,
                'client_role' => 'marketing manager',
                'created_at' => '2022-12-19 03:16:12',
                'id' => 3,
                'updated_at' => '2022-12-19 03:16:12',
            ],
            3 => [
                'client_id' => 1,
                'client_role' => 'marketing manager',
                'created_at' => '2022-12-19 03:16:38',
                'id' => 4,
                'updated_at' => '2022-12-19 03:16:38',
            ],
        ]);
    }
}
