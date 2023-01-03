<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupportRequestChatsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('support_request_chats')->delete();
    }
}
