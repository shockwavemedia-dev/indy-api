<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_users')->delete();

        \DB::table('admin_users')->insert([
            0 => [
                'admin_role' => 'admin',
                'created_at' => '2022-12-16 05:25:05',
                'id' => 1,
                'updated_at' => '2022-12-16 05:25:05',
            ],
            1 => [
                'admin_role' => 'manager',
                'created_at' => '2022-12-18 23:37:09',
                'id' => 2,
                'updated_at' => '2022-12-18 23:37:09',
            ],
            2 => [
                'admin_role' => 'manager',
                'created_at' => '2022-12-18 23:37:52',
                'id' => 3,
                'updated_at' => '2022-12-18 23:37:52',
            ],
            3 => [
                'admin_role' => 'manager',
                'created_at' => '2022-12-18 23:38:39',
                'id' => 4,
                'updated_at' => '2022-12-18 23:38:39',
            ],
            4 => [
                'admin_role' => 'manager',
                'created_at' => '2022-12-18 23:39:58',
                'id' => 5,
                'updated_at' => '2022-12-18 23:39:58',
            ],
        ]);
    }
}
