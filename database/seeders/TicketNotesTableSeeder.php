<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketNotesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ticket_notes')->delete();
        
        \DB::table('ticket_notes')->insert(array (
            0 => 
            array (
                'created_at' => '2022-12-19 00:46:56',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 1,
                'note' => '{"blocks": [{"key": "2gm2p", "data": {}, "text": "When can i expect this returned?", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'ticket_file_version_id' => NULL,
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:46:56',
                'updated_by' => NULL,
            ),
            1 => 
            array (
                'created_at' => '2022-12-19 00:47:02',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 2,
                'note' => '{"blocks": [{"key": "2gm2p", "data": {}, "text": "When can i expect this returned?", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'ticket_file_version_id' => NULL,
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:47:02',
                'updated_by' => NULL,
            ),
            2 => 
            array (
                'created_at' => '2022-12-19 22:25:22',
                'created_by' => 3,
                'deleted_at' => NULL,
                'id' => 3,
                'note' => '{"blocks": [{"key": "9la09", "data": {}, "text": "Hi, Could you please send me a copy of your logo?", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'ticket_file_version_id' => NULL,
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 22:25:22',
                'updated_by' => NULL,
            ),
            3 => 
            array (
                'created_at' => '2022-12-19 22:50:17',
                'created_by' => 5,
                'deleted_at' => NULL,
                'id' => 4,
                'note' => '{"blocks": [{"key": "cmhk1", "data": {}, "text": "Perhaps we split the $400 boost budget over two posts?", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'ticket_file_version_id' => NULL,
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 22:50:17',
                'updated_by' => NULL,
            ),
            4 => 
            array (
                'created_at' => '2022-12-20 04:29:55',
                'created_by' => 6,
                'deleted_at' => NULL,
                'id' => 5,
                'note' => '{"blocks": [{"key": "fg64", "data": {}, "text": "The changes to your Website Header are complete, please check and let me know what you think.", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'ticket_file_version_id' => NULL,
                'ticket_id' => 5,
                'updated_at' => '2022-12-20 04:29:55',
                'updated_by' => NULL,
            ),
        ));
        
        
    }
}