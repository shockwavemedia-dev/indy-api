<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrinterJobAttachmentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('printer_job_attachments')->delete();
    }
}
