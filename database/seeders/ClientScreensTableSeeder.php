<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientScreensTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('client_screens')->delete();
    }
}
