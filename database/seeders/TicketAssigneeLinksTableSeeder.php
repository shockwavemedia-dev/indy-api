<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketAssigneeLinksTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ticket_assignee_links')->delete();
    }
}
