<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketFileVersionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ticket_file_versions')->delete();

        \DB::table('ticket_file_versions')->insert([
            0 => [
                'created_at' => '2022-12-19 23:39:44',
                'file_id' => 348,
                'id' => 1,
                'status' => 'new',
                'ticket_file_id' => 1,
                'updated_at' => '2022-12-19 23:39:44',
                'version' => 1,
            ],
            1 => [
                'created_at' => '2022-12-20 00:48:35',
                'file_id' => 357,
                'id' => 2,
                'status' => 'new',
                'ticket_file_id' => 2,
                'updated_at' => '2022-12-20 00:48:35',
                'version' => 1,
            ],
        ]);
    }
}
