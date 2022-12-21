<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketEmailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ticket_emails')->delete();
        
        
        
    }
}