<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketEmailAttachmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ticket_email_attachments')->delete();
        
        
        
    }
}