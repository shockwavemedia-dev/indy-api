<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketEventAttachmentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ticket_event_attachments')->delete();

        \DB::table('ticket_event_attachments')->insert([
            0 => [
                'file_id' => 78,
                'id' => 1,
                'ticket_event_id' => 8,
            ],
        ]);
    }
}
