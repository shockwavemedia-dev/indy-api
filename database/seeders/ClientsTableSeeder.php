<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clients')->delete();
        
        \DB::table('clients')->insert(array (
            0 => 
            array (
                'address' => '1 somewhere street',
                'client_code' => 'DA1',
                'client_since' => '2022-11-30 00:00:00',
                'created_at' => '2022-12-18 23:23:04',
                'deleted_at' => NULL,
                'designated_animator_id' => 3,
                'designated_designer_id' => 2,
                'designated_printer_manager_id' => NULL,
                'designated_social_media_manager_id' => 4,
                'designated_web_editor_id' => 5,
                'id' => 1,
                'logo_file_id' => 2,
                'main_client_id' => 0,
                'name' => 'Demo Account',
                'note' => NULL,
                'overview' => '{"blocks":[{"key":"c61e1","text":"Client demo account","type":"unstyled","depth":0,"inlineStyleRanges":[],"entityRanges":[],"data":{}}],"entityMap":{}}',
                'owner_id' => NULL,
                'phone' => '01234567',
                'printer_id' => 1,
                'rating' => 5,
                'screen_id' => NULL,
                'status' => 'active',
                'style_guide' => NULL,
            'timezone' => '(UTC+10:00) Canberra, Melbourne, Sydney',
                'updated_at' => '2022-12-18 23:40:12',
            ),
        ));
        
        
    }
}