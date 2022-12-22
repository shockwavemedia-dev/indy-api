<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('notifications')->delete();
        
        \DB::table('notifications')->insert(array (
            0 => 
            array (
                'created_at' => '2022-12-19 00:35:39',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 1,
                'link' => 'ticket/1',
                'morphable_id' => 1,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-1 to you',
                'updated_at' => '2022-12-19 00:35:39',
            ),
            1 => 
            array (
                'created_at' => '2022-12-19 00:35:39',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 2,
                'link' => 'ticket/1',
                'morphable_id' => 2,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-1 to you',
                'updated_at' => '2022-12-19 00:35:39',
            ),
            2 => 
            array (
                'created_at' => '2022-12-19 00:35:39',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 3,
                'link' => 'ticket/1',
                'morphable_id' => 3,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-1 to you',
                'updated_at' => '2022-12-19 00:35:39',
            ),
            3 => 
            array (
                'created_at' => '2022-12-19 00:35:40',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 4,
                'link' => 'ticket/1',
                'morphable_id' => 4,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-1 to you',
                'updated_at' => '2022-12-19 00:35:40',
            ),
            4 => 
            array (
                'created_at' => '2022-12-19 00:36:53',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 5,
                'link' => 'ticket/2',
                'morphable_id' => 5,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-2 to you',
                'updated_at' => '2022-12-19 00:36:53',
            ),
            5 => 
            array (
                'created_at' => '2022-12-19 00:36:53',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 6,
                'link' => 'ticket/2',
                'morphable_id' => 6,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-2 to you',
                'updated_at' => '2022-12-19 00:36:53',
            ),
            6 => 
            array (
                'created_at' => '2022-12-19 00:36:54',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 7,
                'link' => 'ticket/2',
                'morphable_id' => 7,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-2 to you',
                'updated_at' => '2022-12-19 00:36:54',
            ),
            7 => 
            array (
                'created_at' => '2022-12-19 00:36:54',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 8,
                'link' => 'ticket/2',
                'morphable_id' => 8,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-2 to you',
                'updated_at' => '2022-12-19 00:36:54',
            ),
            8 => 
            array (
                'created_at' => '2022-12-19 00:38:00',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 9,
                'link' => 'ticket/3',
                'morphable_id' => 9,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-3 to you',
                'updated_at' => '2022-12-19 00:38:00',
            ),
            9 => 
            array (
                'created_at' => '2022-12-19 00:38:01',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 10,
                'link' => 'ticket/3',
                'morphable_id' => 10,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-3 to you',
                'updated_at' => '2022-12-19 00:38:01',
            ),
            10 => 
            array (
                'created_at' => '2022-12-19 00:38:55',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 11,
                'link' => 'ticket/4',
                'morphable_id' => 11,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-4 to you',
                'updated_at' => '2022-12-19 00:38:55',
            ),
            11 => 
            array (
                'created_at' => '2022-12-19 00:38:55',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 12,
                'link' => 'ticket/4',
                'morphable_id' => 12,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-4 to you',
                'updated_at' => '2022-12-19 00:38:55',
            ),
            12 => 
            array (
                'created_at' => '2022-12-19 00:38:56',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 13,
                'link' => 'ticket/4',
                'morphable_id' => 13,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-4 to you',
                'updated_at' => '2022-12-19 00:38:56',
            ),
            13 => 
            array (
                'created_at' => '2022-12-19 00:38:56',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 14,
                'link' => 'ticket/4',
                'morphable_id' => 14,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-4 to you',
                'updated_at' => '2022-12-19 00:38:56',
            ),
            14 => 
            array (
                'created_at' => '2022-12-19 00:40:24',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 15,
                'link' => 'ticket/5',
                'morphable_id' => 15,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-5 to you',
                'updated_at' => '2022-12-19 00:40:24',
            ),
            15 => 
            array (
                'created_at' => '2022-12-19 00:40:25',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 16,
                'link' => 'ticket/5',
                'morphable_id' => 16,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-5 to you',
                'updated_at' => '2022-12-19 00:40:25',
            ),
            16 => 
            array (
                'created_at' => '2022-12-19 00:40:26',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 17,
                'link' => 'ticket/5',
                'morphable_id' => 17,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-5 to you',
                'updated_at' => '2022-12-19 00:40:26',
            ),
            17 => 
            array (
                'created_at' => '2022-12-19 00:40:26',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 18,
                'link' => 'ticket/5',
                'morphable_id' => 18,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-5 to you',
                'updated_at' => '2022-12-19 00:40:26',
            ),
            18 => 
            array (
                'created_at' => '2022-12-19 00:42:51',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 19,
                'link' => 'ticket/6',
                'morphable_id' => 19,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-6 to you',
                'updated_at' => '2022-12-19 00:42:51',
            ),
            19 => 
            array (
                'created_at' => '2022-12-19 00:42:51',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 20,
                'link' => 'ticket/6',
                'morphable_id' => 20,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-6 to you',
                'updated_at' => '2022-12-19 00:42:51',
            ),
            20 => 
            array (
                'created_at' => '2022-12-19 00:42:51',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 21,
                'link' => 'ticket/6',
                'morphable_id' => 21,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-6 to you',
                'updated_at' => '2022-12-19 00:42:51',
            ),
            21 => 
            array (
                'created_at' => '2022-12-19 00:42:51',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 22,
                'link' => 'ticket/6',
                'morphable_id' => 22,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-6 to you',
                'updated_at' => '2022-12-19 00:42:51',
            ),
            22 => 
            array (
                'created_at' => '2022-12-19 00:45:15',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 23,
                'link' => 'ticket/7',
                'morphable_id' => 23,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-7 to you',
                'updated_at' => '2022-12-19 00:45:15',
            ),
            23 => 
            array (
                'created_at' => '2022-12-19 00:45:16',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 24,
                'link' => 'ticket/7',
                'morphable_id' => 24,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-7 to you',
                'updated_at' => '2022-12-19 00:45:16',
            ),
            24 => 
            array (
                'created_at' => '2022-12-19 00:45:16',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 25,
                'link' => 'ticket/7',
                'morphable_id' => 25,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-7 to you',
                'updated_at' => '2022-12-19 00:45:16',
            ),
            25 => 
            array (
                'created_at' => '2022-12-19 00:45:16',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 26,
                'link' => 'ticket/7',
                'morphable_id' => 26,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-7 to you',
                'updated_at' => '2022-12-19 00:45:16',
            ),
            26 => 
            array (
                'created_at' => '2022-12-19 00:46:56',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 27,
                'link' => 'ticket/7',
                'morphable_id' => 1,
                'morphable_type' => 'App\\Models\\Tickets\\TicketNote',
                'status' => 'new',
                'title' => 'Super Admin has posted a message in ticket # DA1-7',
                'updated_at' => '2022-12-19 00:46:56',
            ),
            27 => 
            array (
                'created_at' => '2022-12-19 00:47:02',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 28,
                'link' => 'ticket/7',
                'morphable_id' => 2,
                'morphable_type' => 'App\\Models\\Tickets\\TicketNote',
                'status' => 'new',
                'title' => 'Super Admin has posted a message in ticket # DA1-7',
                'updated_at' => '2022-12-19 00:47:02',
            ),
            28 => 
            array (
                'created_at' => '2022-12-19 22:25:22',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 29,
                'link' => 'ticket/6',
                'morphable_id' => 3,
                'morphable_type' => 'App\\Models\\Tickets\\TicketNote',
                'status' => 'new',
                'title' => 'Jacob has posted a message in ticket # DA1-6',
                'updated_at' => '2022-12-19 22:25:22',
            ),
            29 => 
            array (
                'created_at' => '2022-12-19 22:50:17',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 30,
                'link' => 'ticket/4',
                'morphable_id' => 4,
                'morphable_type' => 'App\\Models\\Tickets\\TicketNote',
                'status' => 'new',
                'title' => 'Bec has posted a message in ticket # DA1-4',
                'updated_at' => '2022-12-19 22:50:17',
            ),
            30 => 
            array (
                'created_at' => '2022-12-19 23:39:44',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 31,
                'link' => 'ticket/7',
                'morphable_id' => 1,
                'morphable_type' => 'App\\Models\\Tickets\\ClientTicketFile',
                'status' => 'new',
                'title' => 'File was uploaded in Ticket# DA1-7.',
                'updated_at' => '2022-12-19 23:39:44',
            ),
            31 => 
            array (
                'created_at' => '2022-12-19 23:39:52',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 32,
                'link' => 'ticket/file/1',
                'morphable_id' => 1,
                'morphable_type' => 'App\\Models\\Tickets\\ClientTicketFile',
                'status' => 'new',
                'title' => 'John is requesting approval for a design in ticket # DA1-7',
                'updated_at' => '2022-12-19 23:39:52',
            ),
            32 => 
            array (
                'created_at' => '2022-12-20 00:48:35',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 33,
                'link' => 'ticket/1',
                'morphable_id' => 2,
                'morphable_type' => 'App\\Models\\Tickets\\ClientTicketFile',
                'status' => 'new',
                'title' => 'File was uploaded in Ticket# DA1-1.',
                'updated_at' => '2022-12-20 00:48:35',
            ),
            33 => 
            array (
                'created_at' => '2022-12-20 00:48:38',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 34,
                'link' => 'ticket/file/2',
                'morphable_id' => 2,
                'morphable_type' => 'App\\Models\\Tickets\\ClientTicketFile',
                'status' => 'new',
                'title' => 'Jacob is requesting approval for a design in ticket # DA1-1',
                'updated_at' => '2022-12-20 00:48:38',
            ),
            34 => 
            array (
                'created_at' => '2022-12-20 04:29:55',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 35,
                'link' => 'ticket/5',
                'morphable_id' => 5,
                'morphable_type' => 'App\\Models\\Tickets\\TicketNote',
                'status' => 'new',
                'title' => 'Lisa has posted a message in ticket # DA1-5',
                'updated_at' => '2022-12-20 04:29:55',
            ),
            35 => 
            array (
                'created_at' => '2022-12-20 04:35:05',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 36,
                'link' => 'ticket/8',
                'morphable_id' => 27,
                'morphable_type' => 'App\\Models\\Tickets\\TicketAssignee',
                'status' => 'new',
                'title' => 'The Indy Platform has assigned a ticket # DA1-8 to you',
                'updated_at' => '2022-12-20 04:35:05',
            ),
        ));
        
        
    }
}