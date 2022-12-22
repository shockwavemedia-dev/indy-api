<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FileFeedbacksTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('file_feedbacks')->delete();
    }
}
