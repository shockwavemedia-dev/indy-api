<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientTicketFilesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('client_ticket_files')->delete();

        \DB::table('client_ticket_files')->insert([
            0 => [
                'admin_user_id' => 3,
                'approved_at' => null,
                'approved_by' => null,
                'client_id' => 1,
                'created_at' => '2022-12-19 23:39:43',
                'deleted_at' => null,
                'description' => null,
                'file_id' => 348,
                'id' => 1,
                'status' => 'new',
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 23:39:43',
            ],
            1 => [
                'admin_user_id' => 2,
                'approved_at' => null,
                'approved_by' => null,
                'client_id' => 1,
                'created_at' => '2022-12-20 00:48:33',
                'deleted_at' => null,
                'description' => null,
                'file_id' => 357,
                'id' => 2,
                'status' => 'new',
                'ticket_id' => 1,
                'updated_at' => '2022-12-20 00:48:33',
            ],
        ]);
    }
}
