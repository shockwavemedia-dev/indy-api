<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('services')->delete();

        \DB::table('services')->insert([
            0 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => '["Facebook", "Instagram", "Youtube", "Twitter", "Tiktok"]',
                'id' => 1,
                'name' => 'Social Media Spend',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            1 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => '["Bank Ends", "Landscape", "Portrait", "MP4", "Bank Ends", "POS", "EGM", "Custom", "Social Media"]',
                'id' => 2,
                'name' => 'Animation',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            2 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => '["DL", "A4", "A3", "A2", "A1", "POS", "Pull-up Banner", "Whats on Guide", "Hi apps", "Facebook", "Instagram", "TV Screen"]',
                'id' => 3,
                'name' => 'Graphic Design',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            3 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => '["Facebook Event", "Facebook Post", "Instagram", "Twitter"]',
                'id' => 4,
                'name' => 'Social Media',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            4 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => '["Homepage Header", "What\'s On", "Bistro", "Custom"]',
                'id' => 5,
                'name' => 'Website',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            5 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => null,
                'id' => 6,
                'name' => 'Visuals',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            6 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => null,
                'id' => 7,
                'name' => 'EDM',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            7 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => '["A0", "A1", "A2", "A3", "A4", "Pull Up Banner", "Blades Sign", "DL Postcard", "Doublesided DL", "Doublesided A4", "Custom"]',
                'id' => 8,
                'name' => 'Print',
                'updated_at' => '2022-12-16 05:25:05',
            ],
            8 => [
                'created_at' => '2022-12-16 05:25:05',
                'deleted_at' => null,
                'extras' => null,
                'id' => 9,
                'name' => 'Screen Manager',
                'updated_at' => '2022-12-16 05:25:05',
            ],
        ]);
    }
}
