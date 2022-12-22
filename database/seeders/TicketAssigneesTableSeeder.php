<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketAssigneesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ticket_assignees')->delete();
        
        \DB::table('ticket_assignees')->insert(array (
            0 => 
            array (
                'admin_user_id' => 2,
                'created_at' => '2022-12-19 00:35:37',
                'created_by' => 1,
                'department_id' => 2,
                'id' => 1,
                'status' => 'open',
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:37',
                'updated_by' => NULL,
            ),
            1 => 
            array (
                'admin_user_id' => 3,
                'created_at' => '2022-12-19 00:35:39',
                'created_by' => 1,
                'department_id' => 1,
                'id' => 2,
                'status' => 'open',
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:39',
                'updated_by' => NULL,
            ),
            2 => 
            array (
                'admin_user_id' => 5,
                'created_at' => '2022-12-19 00:35:39',
                'created_by' => 1,
                'department_id' => 7,
                'id' => 3,
                'status' => 'open',
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:39',
                'updated_by' => NULL,
            ),
            3 => 
            array (
                'admin_user_id' => 4,
                'created_at' => '2022-12-19 00:35:40',
                'created_by' => 1,
                'department_id' => 6,
                'id' => 4,
                'status' => 'open',
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:40',
                'updated_by' => NULL,
            ),
            4 => 
            array (
                'admin_user_id' => 2,
                'created_at' => '2022-12-19 00:36:52',
                'created_by' => 1,
                'department_id' => 2,
                'id' => 5,
                'status' => 'open',
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:52',
                'updated_by' => NULL,
            ),
            5 => 
            array (
                'admin_user_id' => 3,
                'created_at' => '2022-12-19 00:36:53',
                'created_by' => 1,
                'department_id' => 1,
                'id' => 6,
                'status' => 'open',
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:53',
                'updated_by' => NULL,
            ),
            6 => 
            array (
                'admin_user_id' => 5,
                'created_at' => '2022-12-19 00:36:54',
                'created_by' => 1,
                'department_id' => 7,
                'id' => 7,
                'status' => 'open',
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:54',
                'updated_by' => NULL,
            ),
            7 => 
            array (
                'admin_user_id' => 4,
                'created_at' => '2022-12-19 00:36:54',
                'created_by' => 1,
                'department_id' => 6,
                'id' => 8,
                'status' => 'open',
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:54',
                'updated_by' => NULL,
            ),
            8 => 
            array (
                'admin_user_id' => 3,
                'created_at' => '2022-12-19 00:37:58',
                'created_by' => 1,
                'department_id' => 1,
                'id' => 9,
                'status' => 'open',
                'ticket_id' => 3,
                'updated_at' => '2022-12-19 00:37:58',
                'updated_by' => NULL,
            ),
            9 => 
            array (
                'admin_user_id' => 4,
                'created_at' => '2022-12-19 00:38:00',
                'created_by' => 1,
                'department_id' => 6,
                'id' => 10,
                'status' => 'open',
                'ticket_id' => 3,
                'updated_at' => '2022-12-19 00:38:00',
                'updated_by' => NULL,
            ),
            10 => 
            array (
                'admin_user_id' => 5,
                'created_at' => '2022-12-19 00:38:54',
                'created_by' => 1,
                'department_id' => 7,
                'id' => 11,
                'status' => 'open',
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:54',
                'updated_by' => NULL,
            ),
            11 => 
            array (
                'admin_user_id' => 2,
                'created_at' => '2022-12-19 00:38:55',
                'created_by' => 1,
                'department_id' => 2,
                'id' => 12,
                'status' => 'open',
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:55',
                'updated_by' => NULL,
            ),
            12 => 
            array (
                'admin_user_id' => 3,
                'created_at' => '2022-12-19 00:38:55',
                'created_by' => 1,
                'department_id' => 1,
                'id' => 13,
                'status' => 'open',
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:55',
                'updated_by' => NULL,
            ),
            13 => 
            array (
                'admin_user_id' => 4,
                'created_at' => '2022-12-19 00:38:56',
                'created_by' => 1,
                'department_id' => 6,
                'id' => 14,
                'status' => 'open',
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:56',
                'updated_by' => NULL,
            ),
            14 => 
            array (
                'admin_user_id' => 2,
                'created_at' => '2022-12-19 00:40:22',
                'created_by' => 1,
                'department_id' => 2,
                'id' => 15,
                'status' => 'open',
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:22',
                'updated_by' => NULL,
            ),
            15 => 
            array (
                'admin_user_id' => 5,
                'created_at' => '2022-12-19 00:40:24',
                'created_by' => 1,
                'department_id' => 7,
                'id' => 16,
                'status' => 'open',
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:24',
                'updated_by' => NULL,
            ),
            16 => 
            array (
                'admin_user_id' => 3,
                'created_at' => '2022-12-19 00:40:25',
                'created_by' => 1,
                'department_id' => 1,
                'id' => 17,
                'status' => 'open',
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:25',
                'updated_by' => NULL,
            ),
            17 => 
            array (
                'admin_user_id' => 4,
                'created_at' => '2022-12-19 00:40:26',
                'created_by' => 1,
                'department_id' => 6,
                'id' => 18,
                'status' => 'open',
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:26',
                'updated_by' => NULL,
            ),
            18 => 
            array (
                'admin_user_id' => 2,
                'created_at' => '2022-12-19 00:42:50',
                'created_by' => 1,
                'department_id' => 2,
                'id' => 19,
                'status' => 'open',
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:50',
                'updated_by' => NULL,
            ),
            19 => 
            array (
                'admin_user_id' => 3,
                'created_at' => '2022-12-19 00:42:51',
                'created_by' => 1,
                'department_id' => 1,
                'id' => 20,
                'status' => 'open',
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:51',
                'updated_by' => NULL,
            ),
            20 => 
            array (
                'admin_user_id' => 5,
                'created_at' => '2022-12-19 00:42:51',
                'created_by' => 1,
                'department_id' => 7,
                'id' => 21,
                'status' => 'open',
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:51',
                'updated_by' => NULL,
            ),
            21 => 
            array (
                'admin_user_id' => 4,
                'created_at' => '2022-12-19 00:42:51',
                'created_by' => 1,
                'department_id' => 6,
                'id' => 22,
                'status' => 'open',
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:51',
                'updated_by' => NULL,
            ),
            22 => 
            array (
                'admin_user_id' => 2,
                'created_at' => '2022-12-19 00:45:15',
                'created_by' => 1,
                'department_id' => 2,
                'id' => 23,
                'status' => 'open',
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:15',
                'updated_by' => NULL,
            ),
            23 => 
            array (
                'admin_user_id' => 3,
                'created_at' => '2022-12-19 00:45:15',
                'created_by' => 1,
                'department_id' => 1,
                'id' => 24,
                'status' => 'open',
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:15',
                'updated_by' => NULL,
            ),
            24 => 
            array (
                'admin_user_id' => 5,
                'created_at' => '2022-12-19 00:45:16',
                'created_by' => 1,
                'department_id' => 7,
                'id' => 25,
                'status' => 'open',
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:16',
                'updated_by' => NULL,
            ),
            25 => 
            array (
                'admin_user_id' => 4,
                'created_at' => '2022-12-19 00:45:16',
                'created_by' => 1,
                'department_id' => 6,
                'id' => 26,
                'status' => 'open',
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:16',
                'updated_by' => NULL,
            ),
            26 => 
            array (
                'admin_user_id' => 3,
                'created_at' => '2022-12-20 04:35:04',
                'created_by' => 1,
                'department_id' => 1,
                'id' => 27,
                'status' => 'open',
                'ticket_id' => 8,
                'updated_at' => '2022-12-20 04:35:04',
                'updated_by' => NULL,
            ),
        ));
        
        
    }
}