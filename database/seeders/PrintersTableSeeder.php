<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrintersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('printers')->delete();

        \DB::table('printers')->insert([
            0 => [
                'company_name' => 'Daily Press',
                'contact_name' => 'wayne',
                'created_at' => '2022-12-18 23:35:38',
                'created_by' => 1,
                'deleted_at' => null,
                'description' => null,
                'file_id' => 3,
                'id' => 1,
                'phone' => null,
                'updated_at' => '2022-12-18 23:35:38',
                'updated_by' => null,
            ],
        ]);
    }
}
