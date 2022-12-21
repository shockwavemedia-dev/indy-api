<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailboxInboundEmailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mailbox_inbound_emails')->delete();
        
        
        
    }
}