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
        
        \DB::table('marketing_planner_task_assignees')->insert(array (
            0 => 
            array (
                'created_at' => '2022-12-20 05:46:41',
                'deadline' => NULL,
                'id' => 3,
                'status' => NULL,
                'task_id' => 3,
                'updated_at' => '2022-12-20 05:46:41',
                'user_id' => 10,
            ),
        ));
        
        
    }
}