<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SocialMediaTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('social_media')->delete();

        \DB::table('social_media')->insert([
            0 => [
                'campaign_type' => null,
                'channels' => '[{"name": "Facebook Event", "quantity": "50"}, {"name": "Facebook Post", "quantity": 0}, {"name": "Instagram", "quantity": "100"}]',
                'client_id' => 1,
                'copy' => null,
                'created_at' => '2022-12-19 00:35:40',
                'created_by' => 7,
                'deleted_at' => null,
                'id' => 1,
                'notes' => null,
                'post' => 'Melbourne Cup',
                'post_date' => '2022-12-29 18:35:40',
                'status' => 'Approved',
                'ticket_id' => 1,
                'updated_at' => '2022-12-20 01:39:58',
                'updated_by' => null,
            ],
            1 => [
                'campaign_type' => null,
                'channels' => '[{"name": "Facebook Post", "quantity": "400"}]',
                'client_id' => 1,
                'copy' => null,
                'created_at' => '2022-12-19 00:36:54',
                'created_by' => 7,
                'deleted_at' => null,
                'id' => 2,
                'notes' => null,
                'post' => 'Mega Draw Eggcitment',
                'post_date' => '2023-03-11 21:36:54',
                'status' => 'Client Created Draft',
                'ticket_id' => 2,
                'updated_at' => '2022-12-20 01:39:44',
                'updated_by' => null,
            ],
            2 => [
                'campaign_type' => null,
                'channels' => '[{"name": "Instagram", "quantity": "0"}, {"name": "Story", "quantity": 0}, {"name": "Video Reels", "quantity": 0}]',
                'client_id' => 1,
                'copy' => null,
                'created_at' => '2022-12-19 00:38:00',
                'created_by' => 7,
                'deleted_at' => null,
                'id' => 3,
                'notes' => null,
                'post' => 'Australia Day 2023',
                'post_date' => '2023-02-15 07:38:00',
                'status' => 'Scheduled',
                'ticket_id' => 3,
                'updated_at' => '2022-12-20 01:39:25',
                'updated_by' => null,
            ],
            3 => [
                'campaign_type' => null,
                'channels' => '[{"name": "Facebook Post", "quantity": "400"}]',
                'client_id' => 1,
                'copy' => null,
                'created_at' => '2022-12-19 00:38:56',
                'created_by' => 7,
                'deleted_at' => null,
                'id' => 4,
                'notes' => null,
                'post' => 'Mother\'s Day',
                'post_date' => '2023-01-25 16:38:56',
                'status' => 'Approved',
                'ticket_id' => 4,
                'updated_at' => '2022-12-20 01:39:08',
                'updated_by' => null,
            ],
            4 => [
                'campaign_type' => null,
                'channels' => '[{"name": "Facebook Post", "quantity": "0"}, {"name": "Facebook Event", "quantity": 0}]',
                'client_id' => 1,
                'copy' => null,
                'created_at' => '2022-12-19 00:40:26',
                'created_by' => 7,
                'deleted_at' => null,
                'id' => 5,
                'notes' => null,
                'post' => 'Anzac Day',
                'post_date' => '2023-01-11 13:00:26',
                'status' => 'To Approve',
                'ticket_id' => 5,
                'updated_at' => '2022-12-20 01:38:53',
                'updated_by' => null,
            ],
            5 => [
                'campaign_type' => null,
                'channels' => '[{"name": "Instagram", "quantity": "0"}]',
                'client_id' => 1,
                'copy' => null,
                'created_at' => '2022-12-19 00:42:51',
                'created_by' => 7,
                'deleted_at' => null,
                'id' => 6,
                'notes' => null,
                'post' => 'Step into Spring',
                'post_date' => '2022-12-19 00:42:51',
                'status' => 'Client Created Draft',
                'ticket_id' => 6,
                'updated_at' => '2022-12-19 00:42:51',
                'updated_by' => null,
            ],
            6 => [
                'campaign_type' => null,
                'channels' => '[{"name": "Instagram", "quantity": "80"}, {"name": "Tik Tok", "quantity": 0}]',
                'client_id' => 1,
                'copy' => null,
                'created_at' => '2022-12-19 00:45:16',
                'created_by' => 7,
                'deleted_at' => null,
                'id' => 7,
                'notes' => null,
                'post' => 'World Cup Major Promo',
                'post_date' => '2022-12-21 00:45:16',
                'status' => 'To Approve',
                'ticket_id' => 7,
                'updated_at' => '2022-12-20 01:33:58',
                'updated_by' => null,
            ],
        ]);
    }
}
