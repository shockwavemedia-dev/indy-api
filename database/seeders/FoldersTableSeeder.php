<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FoldersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('folders')->delete();

        \DB::table('folders')->insert([
            0 => [
                'client_id' => 1,
                'created_at' => '2022-12-18 23:25:10',
                'created_by' => 1,
                'deleted_at' => null,
                'id' => 1,
                'name' => 'Graphics',
                'parent_folder_id' => null,
                'updated_at' => '2022-12-18 23:25:10',
                'updated_by' => null,
            ],
            1 => [
                'client_id' => 1,
                'created_at' => '2022-12-18 23:26:05',
                'created_by' => 1,
                'deleted_at' => null,
                'id' => 2,
                'name' => 'Animations',
                'parent_folder_id' => null,
                'updated_at' => '2022-12-18 23:26:05',
                'updated_by' => null,
            ],
            2 => [
                'client_id' => 1,
                'created_at' => '2022-12-18 23:26:17',
                'created_by' => 1,
                'deleted_at' => null,
                'id' => 3,
                'name' => 'Videos',
                'parent_folder_id' => null,
                'updated_at' => '2022-12-18 23:26:17',
                'updated_by' => null,
            ],
        ]);
    }
}
