<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketActivitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ticket_activities')->delete();
        
        \DB::table('ticket_activities')->insert(array (
            0 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-1 to Jacob',
                'created_at' => '2022-12-19 00:35:39',
                'id' => 1,
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:39',
                'user_id' => 1,
            ),
            1 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-1 to John',
                'created_at' => '2022-12-19 00:35:39',
                'id' => 2,
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:39',
                'user_id' => 1,
            ),
            2 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-1 to Lisa',
                'created_at' => '2022-12-19 00:35:39',
                'id' => 3,
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:39',
                'user_id' => 1,
            ),
            3 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-1 to Bec',
                'created_at' => '2022-12-19 00:35:40',
                'id' => 4,
                'ticket_id' => 1,
                'updated_at' => '2022-12-19 00:35:40',
                'user_id' => 1,
            ),
            4 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-2 to Jacob',
                'created_at' => '2022-12-19 00:36:53',
                'id' => 5,
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:53',
                'user_id' => 1,
            ),
            5 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-2 to John',
                'created_at' => '2022-12-19 00:36:53',
                'id' => 6,
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:53',
                'user_id' => 1,
            ),
            6 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-2 to Lisa',
                'created_at' => '2022-12-19 00:36:54',
                'id' => 7,
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:54',
                'user_id' => 1,
            ),
            7 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-2 to Bec',
                'created_at' => '2022-12-19 00:36:54',
                'id' => 8,
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:36:54',
                'user_id' => 1,
            ),
            8 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-3 to John',
                'created_at' => '2022-12-19 00:38:00',
                'id' => 9,
                'ticket_id' => 3,
                'updated_at' => '2022-12-19 00:38:00',
                'user_id' => 1,
            ),
            9 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-3 to Bec',
                'created_at' => '2022-12-19 00:38:01',
                'id' => 10,
                'ticket_id' => 3,
                'updated_at' => '2022-12-19 00:38:01',
                'user_id' => 1,
            ),
            10 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-4 to Lisa',
                'created_at' => '2022-12-19 00:38:55',
                'id' => 11,
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:55',
                'user_id' => 1,
            ),
            11 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-4 to Jacob',
                'created_at' => '2022-12-19 00:38:55',
                'id' => 12,
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:55',
                'user_id' => 1,
            ),
            12 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-4 to John',
                'created_at' => '2022-12-19 00:38:56',
                'id' => 13,
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:56',
                'user_id' => 1,
            ),
            13 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-4 to Bec',
                'created_at' => '2022-12-19 00:38:56',
                'id' => 14,
                'ticket_id' => 4,
                'updated_at' => '2022-12-19 00:38:56',
                'user_id' => 1,
            ),
            14 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-5 to Jacob',
                'created_at' => '2022-12-19 00:40:24',
                'id' => 15,
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:24',
                'user_id' => 1,
            ),
            15 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-5 to Lisa',
                'created_at' => '2022-12-19 00:40:25',
                'id' => 16,
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:25',
                'user_id' => 1,
            ),
            16 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-5 to John',
                'created_at' => '2022-12-19 00:40:26',
                'id' => 17,
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:26',
                'user_id' => 1,
            ),
            17 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-5 to Bec',
                'created_at' => '2022-12-19 00:40:26',
                'id' => 18,
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:40:26',
                'user_id' => 1,
            ),
            18 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-6 to Jacob',
                'created_at' => '2022-12-19 00:42:51',
                'id' => 19,
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:51',
                'user_id' => 1,
            ),
            19 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-6 to John',
                'created_at' => '2022-12-19 00:42:51',
                'id' => 20,
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:51',
                'user_id' => 1,
            ),
            20 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-6 to Lisa',
                'created_at' => '2022-12-19 00:42:51',
                'id' => 21,
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:51',
                'user_id' => 1,
            ),
            21 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-6 to Bec',
                'created_at' => '2022-12-19 00:42:51',
                'id' => 22,
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:51',
                'user_id' => 1,
            ),
            22 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-7 to Jacob',
                'created_at' => '2022-12-19 00:45:15',
                'id' => 23,
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:15',
                'user_id' => 1,
            ),
            23 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-7 to John',
                'created_at' => '2022-12-19 00:45:16',
                'id' => 24,
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:16',
                'user_id' => 1,
            ),
            24 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-7 to Lisa',
                'created_at' => '2022-12-19 00:45:16',
                'id' => 25,
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:16',
                'user_id' => 1,
            ),
            25 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-7 to Bec',
                'created_at' => '2022-12-19 00:45:16',
                'id' => 26,
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:45:16',
                'user_id' => 1,
            ),
            26 => 
            array (
                'activity' => 'Super Admin changed the status from Open to Pending.',
                'created_at' => '2022-12-19 00:47:23',
                'id' => 27,
                'ticket_id' => 7,
                'updated_at' => '2022-12-19 00:47:23',
                'user_id' => 1,
            ),
            27 => 
            array (
                'activity' => 'Super Admin changed the status from Open to In_progress.',
                'created_at' => '2022-12-19 00:47:54',
                'id' => 28,
                'ticket_id' => 5,
                'updated_at' => '2022-12-19 00:47:54',
                'user_id' => 1,
            ),
            28 => 
            array (
                'activity' => 'Super Admin changed the status from Open to Pending.',
                'created_at' => '2022-12-19 00:48:39',
                'id' => 29,
                'ticket_id' => 2,
                'updated_at' => '2022-12-19 00:48:39',
                'user_id' => 1,
            ),
            29 => 
            array (
                'activity' => 'Super Admin changed the status from Open to Closed.',
                'created_at' => '2022-12-19 00:49:18',
                'id' => 30,
                'ticket_id' => 3,
                'updated_at' => '2022-12-19 00:49:18',
                'user_id' => 1,
            ),
            30 => 
            array (
                'activity' => 'Super Admin changed the status from Open to Pending.',
                'created_at' => '2022-12-20 00:48:38',
                'id' => 31,
                'ticket_id' => 1,
                'updated_at' => '2022-12-20 00:48:38',
                'user_id' => 1,
            ),
            31 => 
            array (
                'activity' => 'Super Admin assigned this ticket # DA1-8 to John',
                'created_at' => '2022-12-20 04:35:05',
                'id' => 32,
                'ticket_id' => 8,
                'updated_at' => '2022-12-20 04:35:05',
                'user_id' => 1,
            ),
        ));
        
        
    }
}