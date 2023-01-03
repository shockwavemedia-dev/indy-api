<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupportRequestsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('support_requests')->delete();
    }
}
