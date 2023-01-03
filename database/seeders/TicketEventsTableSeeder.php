<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketEventsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ticket_events')->delete();

        \DB::table('ticket_events')->insert([
            0 => [
                'created_at' => '2022-12-19 00:35:40',
                'deleted_at' => null,
                'duedate' => null,
                'id' => 1,
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:40',
            ],
            1 => [
                'created_at' => '2022-12-19 00:36:54',
                'deleted_at' => null,
                'duedate' => null,
                'id' => 2,
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:54',
            ],
            2 => [
                'created_at' => '2022-12-19 00:38:01',
                'deleted_at' => null,
                'duedate' => null,
                'id' => 3,
                'ticket_id' => 3,
                'updated_at' => '2022-12-19 00:38:01',
            ],
            3 => [
                'created_at' => '2022-12-19 00:38:56',
                'deleted_at' => null,
                'duedate' => null,
                'id' => 4,
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:56',
            ],
            4 => [
                'created_at' => '2022-12-19 00:40:26',
                'deleted_at' => null,
                'duedate' => null,
                'id' => 5,
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:26',
            ],
            5 => [
                'created_at' => '2022-12-19 00:42:52',
                'deleted_at' => null,
                'duedate' => null,
                'id' => 6,
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:52',
            ],
            6 => [
                'created_at' => '2022-12-19 00:45:16',
                'deleted_at' => null,
                'duedate' => null,
                'id' => 7,
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:16',
            ],
            7 => [
                'created_at' => '2022-12-20 04:35:04',
                'deleted_at' => null,
                'duedate' => null,
                'id' => 8,
                'ticket_id' => 8,
                'updated_at' => '2022-12-20 04:35:04',
            ],
        ]);
    }
}
