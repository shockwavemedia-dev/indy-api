<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SocialMediaAttachmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('social_media_attachments')->delete();
        
        \DB::table('social_media_attachments')->insert(array (
            0 => 
            array (
                'created_at' => '2022-12-20 01:17:09',
                'file_id' => 358,
                'id' => 1,
                'social_media_id' => 4,
                'updated_at' => '2022-12-20 01:17:09',
            ),
            1 => 
            array (
                'created_at' => '2022-12-20 01:19:45',
                'file_id' => 359,
                'id' => 2,
                'social_media_id' => 4,
                'updated_at' => '2022-12-20 01:19:45',
            ),
            2 => 
            array (
                'created_at' => '2022-12-20 01:20:30',
                'file_id' => 350,
                'id' => 4,
                'social_media_id' => 6,
                'updated_at' => '2022-12-20 01:20:30',
            ),
            3 => 
            array (
                'created_at' => '2022-12-20 01:20:48',
                'file_id' => 351,
                'id' => 5,
                'social_media_id' => 5,
                'updated_at' => '2022-12-20 01:20:48',
            ),
            4 => 
            array (
                'created_at' => '2022-12-20 01:21:59',
                'file_id' => 349,
                'id' => 6,
                'social_media_id' => 1,
                'updated_at' => '2022-12-20 01:21:59',
            ),
        ));
        
        
    }
}