<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NoteAttachmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('note_attachments')->delete();
        
        
        
    }
}