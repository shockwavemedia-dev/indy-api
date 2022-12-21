<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MarketingPlannerTasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('marketing_planner_tasks')->delete();
        
        \DB::table('marketing_planner_tasks')->insert(array (
            0 => 
            array (
                'assignee' => NULL,
                'created_at' => '2022-12-20 05:45:04',
                'deadline' => '2023-02-21',
                'id' => 1,
                'marketing_planner_id' => 1,
                'name' => 'animations',
                'notify' => 0,
                'status' => 'In Progress',
                'updated_at' => '2022-12-20 05:55:22',
            ),
            1 => 
            array (
                'assignee' => NULL,
                'created_at' => '2022-12-20 05:45:04',
                'deadline' => '2022-12-30',
                'id' => 2,
                'marketing_planner_id' => 1,
                'name' => 'website',
                'notify' => 0,
                'status' => 'Todo',
                'updated_at' => '2022-12-20 05:45:04',
            ),
            2 => 
            array (
                'assignee' => NULL,
                'created_at' => '2022-12-20 05:46:41',
                'deadline' => '2022-12-17',
                'id' => 3,
                'marketing_planner_id' => 2,
                'name' => 'web sliders',
                'notify' => 0,
                'status' => 'In Progress',
                'updated_at' => '2022-12-20 05:46:41',
            ),
            3 => 
            array (
                'assignee' => NULL,
                'created_at' => '2022-12-20 05:48:07',
                'deadline' => '2023-09-19',
                'id' => 4,
                'marketing_planner_id' => 3,
                'name' => 'social media posts',
                'notify' => 0,
                'status' => 'Completed',
                'updated_at' => '2022-12-20 05:48:20',
            ),
            4 => 
            array (
                'assignee' => NULL,
                'created_at' => '2022-12-20 05:48:07',
                'deadline' => '2022-11-30',
                'id' => 5,
                'marketing_planner_id' => 3,
                'name' => 'newspaper ads',
                'notify' => 0,
                'status' => 'Todo',
                'updated_at' => '2022-12-20 05:48:07',
            ),
            5 => 
            array (
                'assignee' => NULL,
                'created_at' => '2022-12-20 05:48:07',
                'deadline' => '2023-02-28',
                'id' => 6,
                'marketing_planner_id' => 3,
                'name' => 'digital magazine',
                'notify' => 0,
                'status' => 'In Progress',
                'updated_at' => '2022-12-20 05:48:48',
            ),
        ));
        
        
    }
}