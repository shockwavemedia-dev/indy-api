<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MarketingPlannerTaskAssigneesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('marketing_planner_task_assignees')->delete();

        \DB::table('marketing_planner_task_assignees')->insert([
            0 => [
                'created_at' => '2022-12-20 05:46:41',
                'deadline' => null,
                'id' => 3,
                'status' => null,
                'task_id' => 3,
                'updated_at' => '2022-12-20 05:46:41',
                'user_id' => 10,
            ],
        ]);
    }
}
