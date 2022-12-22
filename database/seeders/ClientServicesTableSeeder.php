<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('client_services')->delete();
        
        \DB::table('client_services')->insert(array (
            0 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => NULL,
                'extras' => '[]',
                'id' => 1,
                'is_enabled' => 0,
                'marketing_quota' => NULL,
                'service_id' => 1,
                'total_used' => NULL,
                'updated_at' => '2022-12-18 23:23:04',
                'updated_by' => NULL,
            ),
            1 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => 0,
                'extras' => '["Bank Ends", "Landscape", "Portrait", "MP4", "POS", "EGM", "Custom", "Social Media"]',
                'id' => 2,
                'is_enabled' => 1,
                'marketing_quota' => 55,
                'service_id' => 2,
                'total_used' => 7,
                'updated_at' => '2022-12-19 00:45:15',
                'updated_by' => 1,
            ),
            2 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => 0,
                'extras' => '["DL", "A4", "A3", "A1", "A2", "Pull-up Banner", "POS", "Whats on Guide", "Hi apps", "Facebook", "Instagram", "TV Screen"]',
                'id' => 3,
                'is_enabled' => 1,
                'marketing_quota' => 100,
                'service_id' => 3,
                'total_used' => 6,
                'updated_at' => '2022-12-19 00:45:15',
                'updated_by' => 1,
            ),
            3 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => 0,
                'extras' => '["Facebook Event", "Facebook Post", "Instagram", "Twitter"]',
                'id' => 4,
                'is_enabled' => 1,
                'marketing_quota' => 0,
                'service_id' => 4,
                'total_used' => 7,
                'updated_at' => '2022-12-19 00:45:16',
                'updated_by' => 1,
            ),
            4 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => 0,
                'extras' => '["Homepage Header", "What\'s On", "Custom", "Bistro"]',
                'id' => 5,
                'is_enabled' => 1,
                'marketing_quota' => 30,
                'service_id' => 5,
                'total_used' => 6,
                'updated_at' => '2022-12-19 00:45:16',
                'updated_by' => 1,
            ),
            5 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => NULL,
                'extras' => '[]',
                'id' => 6,
                'is_enabled' => 0,
                'marketing_quota' => NULL,
                'service_id' => 6,
                'total_used' => NULL,
                'updated_at' => '2022-12-18 23:23:04',
                'updated_by' => NULL,
            ),
            6 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => 0,
                'extras' => '[]',
                'id' => 7,
                'is_enabled' => 1,
                'marketing_quota' => 0,
                'service_id' => 7,
                'total_used' => 6,
                'updated_at' => '2022-12-19 00:45:15',
                'updated_by' => 1,
            ),
            7 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => 0,
                'extras' => '["A0", "A1", "A2", "A3", "A4", "Pull Up Banner", "Blades Sign", "DL Postcard", "Doublesided DL", "Doublesided A4", "Custom"]',
                'id' => 8,
                'is_enabled' => 1,
                'marketing_quota' => 0,
                'service_id' => 8,
                'total_used' => 6,
                'updated_at' => '2022-12-19 00:45:16',
                'updated_by' => 1,
            ),
            8 => 
            array (
                'client_id' => 1,
                'created_at' => '2022-12-18 23:23:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'extra_quota' => NULL,
                'extras' => '[]',
                'id' => 9,
                'is_enabled' => 0,
                'marketing_quota' => NULL,
                'service_id' => 9,
                'total_used' => NULL,
                'updated_at' => '2022-12-18 23:23:04',
                'updated_by' => NULL,
            ),
        ));
        
        
    }
}