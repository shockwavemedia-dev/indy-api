<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketChatsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ticket_chats')->delete();
    }
}
