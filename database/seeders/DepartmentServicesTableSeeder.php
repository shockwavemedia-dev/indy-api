<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentServicesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('department_services')->delete();
    }
}
