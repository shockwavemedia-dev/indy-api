<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('departments')->delete();

        \DB::table('departments')->insert([
            0 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Animation Department',
                'id' => 1,
                'min_delivery_days' => 7,
                'name' => 'Animation Department',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            1 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Graphics Department',
                'id' => 2,
                'min_delivery_days' => 7,
                'name' => 'Graphics Department',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            2 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Printer Department',
                'id' => 3,
                'min_delivery_days' => 7,
                'name' => 'Printer Department',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            3 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Payroll Department',
                'id' => 4,
                'min_delivery_days' => 7,
                'name' => 'Payroll Department',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            4 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Video Production',
                'id' => 5,
                'min_delivery_days' => 7,
                'name' => 'Video Production',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            5 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Social Media',
                'id' => 6,
                'min_delivery_days' => 7,
                'name' => 'Social Media',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            6 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Website Department',
                'id' => 7,
                'min_delivery_days' => 7,
                'name' => 'Website Department',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            7 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Accounts',
                'id' => 8,
                'min_delivery_days' => 7,
                'name' => 'Accounts',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            8 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Advertising Department',
                'id' => 9,
                'min_delivery_days' => 7,
                'name' => 'Advertising Department',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            9 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Customer Support',
                'id' => 10,
                'min_delivery_days' => 7,
                'name' => 'Customer Support',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            10 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'description' => 'Photographer',
                'id' => 11,
                'min_delivery_days' => 7,
                'name' => 'Photographer',
                'status' => 'active',
                'updated_at' => '2022-12-16 05:25:05',
            ],
        ]);
    }
}
