<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminDepartmentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_departments')->delete();

        \DB::table('admin_departments')->insert([
            0 => [
                'admin_user_id' => 2,
                'created_at' => null,
                'department_id' => 2,
                'id' => 1,
                'position' => 'Deisgner',
                'updated_at' => null,
            ],
            1 => [
                'admin_user_id' => 3,
                'created_at' => null,
                'department_id' => 1,
                'id' => 2,
                'position' => 'Manager',
                'updated_at' => null,
            ],
            2 => [
                'admin_user_id' => 4,
                'created_at' => null,
                'department_id' => 6,
                'id' => 3,
                'position' => 'Manager',
                'updated_at' => null,
            ],
            3 => [
                'admin_user_id' => 5,
                'created_at' => null,
                'department_id' => 7,
                'id' => 4,
                'position' => 'Manager',
                'updated_at' => null,
            ],
        ]);
    }
}
