<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AuditsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('audits')->delete();

        \DB::table('audits')->insert([
            0 => [
                'auditable_id' => 1,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-19 00:35:40',
                'event' => 'created',
                'id' => 1,
                'ip_address' => '58.178.82.124',
                'new_values' => '{"campaign_type":null,"post":"Melbourne Cup","ticket_id":1,"copy":null,"status":"Client Created Draft","client_id":1,"channels":"[{\\"name\\":\\"Facebook Event\\",\\"quantity\\":\\"50\\"},{\\"name\\":\\"Facebook Post\\",\\"quantity\\":null},{\\"name\\":\\"Instagram\\",\\"quantity\\":\\"100\\"}]","notes":null,"post_date":"2022-12-19 00:35:40","created_by":7,"id":1}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-19 00:35:40',
                'url' => 'https://api-demo.indy.com.au/api/v1/tickets/event',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            1 => [
                'auditable_id' => 2,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-19 00:36:54',
                'event' => 'created',
                'id' => 2,
                'ip_address' => '58.178.82.124',
                'new_values' => '{"campaign_type":null,"post":"Mega Draw Eggcitment","ticket_id":2,"copy":null,"status":"Client Created Draft","client_id":1,"channels":"[{\\"name\\":\\"Facebook Post\\",\\"quantity\\":\\"400\\"}]","notes":null,"post_date":"2022-12-19 00:36:54","created_by":7,"id":2}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-19 00:36:54',
                'url' => 'https://api-demo.indy.com.au/api/v1/tickets/event',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            2 => [
                'auditable_id' => 3,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-19 00:38:00',
                'event' => 'created',
                'id' => 3,
                'ip_address' => '58.178.82.124',
                'new_values' => '{"campaign_type":null,"post":"Australia Day 2023","ticket_id":3,"copy":null,"status":"Client Created Draft","client_id":1,"channels":"[{\\"name\\":\\"Instagram\\",\\"quantity\\":\\"0\\"}]","notes":null,"post_date":"2022-12-19 00:38:00","created_by":7,"id":3}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-19 00:38:00',
                'url' => 'https://api-demo.indy.com.au/api/v1/tickets/event',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            3 => [
                'auditable_id' => 4,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-19 00:38:56',
                'event' => 'created',
                'id' => 4,
                'ip_address' => '58.178.82.124',
                'new_values' => '{"campaign_type":null,"post":"Mother\'s Day","ticket_id":4,"copy":null,"status":"Client Created Draft","client_id":1,"channels":"[{\\"name\\":\\"Facebook Post\\",\\"quantity\\":\\"400\\"}]","notes":null,"post_date":"2022-12-19 00:38:56","created_by":7,"id":4}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-19 00:38:56',
                'url' => 'https://api-demo.indy.com.au/api/v1/tickets/event',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            4 => [
                'auditable_id' => 5,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-19 00:40:26',
                'event' => 'created',
                'id' => 5,
                'ip_address' => '58.178.82.124',
                'new_values' => '{"campaign_type":null,"post":"Anzac Day","ticket_id":5,"copy":null,"status":"Client Created Draft","client_id":1,"channels":"[{\\"name\\":\\"Facebook Post\\",\\"quantity\\":\\"0\\"}]","notes":null,"post_date":"2022-12-19 00:40:26","created_by":7,"id":5}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-19 00:40:26',
                'url' => 'https://api-demo.indy.com.au/api/v1/tickets/event',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            5 => [
                'auditable_id' => 6,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-19 00:42:51',
                'event' => 'created',
                'id' => 6,
                'ip_address' => '58.178.82.124',
                'new_values' => '{"campaign_type":null,"post":"Step into Spring","ticket_id":6,"copy":null,"status":"Client Created Draft","client_id":1,"channels":"[{\\"name\\":\\"Instagram\\",\\"quantity\\":\\"0\\"}]","notes":null,"post_date":"2022-12-19 00:42:51","created_by":7,"id":6}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-19 00:42:51',
                'url' => 'https://api-demo.indy.com.au/api/v1/tickets/event',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            6 => [
                'auditable_id' => 7,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-19 00:45:16',
                'event' => 'created',
                'id' => 7,
                'ip_address' => '58.178.82.124',
                'new_values' => '{"campaign_type":null,"post":"World Cup Major Promo","ticket_id":7,"copy":null,"status":"Client Created Draft","client_id":1,"channels":"[{\\"name\\":\\"Instagram\\",\\"quantity\\":\\"80\\"}]","notes":null,"post_date":"2022-12-19 00:45:16","created_by":7,"id":7}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-19 00:45:16',
                'url' => 'https://api-demo.indy.com.au/api/v1/tickets/event',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            7 => [
                'auditable_id' => 7,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:14:27',
                'event' => 'updated',
                'id' => 8,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"status":"To Approve"}',
                'old_values' => '{"status":"Client Created Draft"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:14:27',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/7',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            8 => [
                'auditable_id' => 3,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:15:35',
                'event' => 'updated',
                'id' => 9,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"status":"Scheduled"}',
                'old_values' => '{"status":"Client Created Draft"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:15:35',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/3',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            9 => [
                'auditable_id' => 1,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:15:43',
                'event' => 'updated',
                'id' => 10,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"status":"Approved","channels":"[{\\"name\\":\\"Facebook Event\\",\\"quantity\\":\\"50\\"},{\\"name\\":\\"Facebook Post\\",\\"quantity\\":0},{\\"name\\":\\"Instagram\\",\\"quantity\\":\\"100\\"}]"}',
                'old_values' => '{"status":"Client Created Draft","channels":"[{\\"name\\": \\"Facebook Event\\", \\"quantity\\": \\"50\\"}, {\\"name\\": \\"Facebook Post\\", \\"quantity\\": null}, {\\"name\\": \\"Instagram\\", \\"quantity\\": \\"100\\"}]"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:15:43',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            10 => [
                'auditable_id' => 5,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:15:50',
                'event' => 'updated',
                'id' => 11,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"status":"To Approve"}',
                'old_values' => '{"status":"Client Created Draft"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:15:50',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/5',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            11 => [
                'auditable_id' => 7,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:15:56',
                'event' => 'updated',
                'id' => 12,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"channels":"[{\\"name\\":\\"Instagram\\",\\"quantity\\":\\"80\\"},{\\"name\\":\\"Tik Tok\\",\\"quantity\\":0}]"}',
                'old_values' => '{"channels":"[{\\"name\\": \\"Instagram\\", \\"quantity\\": \\"80\\"}]"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:15:56',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/7',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            12 => [
                'auditable_id' => 5,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:16:01',
                'event' => 'updated',
                'id' => 13,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"channels":"[{\\"name\\":\\"Facebook Post\\",\\"quantity\\":\\"0\\"},{\\"name\\":\\"Facebook Event\\",\\"quantity\\":0}]"}',
                'old_values' => '{"channels":"[{\\"name\\": \\"Facebook Post\\", \\"quantity\\": \\"0\\"}]"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:16:01',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/5',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            13 => [
                'auditable_id' => 1,
                'auditable_type' => 'App\\Models\\SocialMediaAttachment',
                'created_at' => '2022-12-20 01:17:09',
                'event' => 'created',
                'id' => 14,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"social_media_id":4,"file_id":358,"id":1}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-20 01:17:09',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/4',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            14 => [
                'auditable_id' => 3,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:18:26',
                'event' => 'updated',
                'id' => 15,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"channels":"[{\\"name\\":\\"Instagram\\",\\"quantity\\":\\"0\\"},{\\"name\\":\\"Story\\",\\"quantity\\":0}]"}',
                'old_values' => '{"channels":"[{\\"name\\": \\"Instagram\\", \\"quantity\\": \\"0\\"}]"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:18:26',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/3',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            15 => [
                'auditable_id' => 3,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:18:33',
                'event' => 'updated',
                'id' => 16,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"channels":"[{\\"name\\":\\"Instagram\\",\\"quantity\\":\\"0\\"},{\\"name\\":\\"Story\\",\\"quantity\\":0},{\\"name\\":\\"Video Reels\\",\\"quantity\\":0}]"}',
                'old_values' => '{"channels":"[{\\"name\\": \\"Instagram\\", \\"quantity\\": \\"0\\"}, {\\"name\\": \\"Story\\", \\"quantity\\": 0}]"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:18:33',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/3',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            16 => [
                'auditable_id' => 2,
                'auditable_type' => 'App\\Models\\SocialMediaAttachment',
                'created_at' => '2022-12-20 01:19:45',
                'event' => 'created',
                'id' => 17,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"social_media_id":4,"file_id":359,"id":2}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-20 01:19:45',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/4',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            17 => [
                'auditable_id' => 3,
                'auditable_type' => 'App\\Models\\SocialMediaAttachment',
                'created_at' => '2022-12-20 01:19:58',
                'event' => 'created',
                'id' => 18,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"social_media_id":4,"file_id":360,"id":3}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-20 01:19:58',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/4',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            18 => [
                'auditable_id' => 4,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:20:17',
                'event' => 'deleted',
                'id' => 19,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"attachment":""}',
                'old_values' => '{"attachment":"01_perkii_burrito_stack_social.mp4"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:20:17',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/4/attachments',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            19 => [
                'auditable_id' => 3,
                'auditable_type' => 'App\\Models\\SocialMediaAttachment',
                'created_at' => '2022-12-20 01:20:18',
                'event' => 'deleted',
                'id' => 20,
                'ip_address' => '122.150.48.224',
                'new_values' => '[]',
                'old_values' => '{"id":3,"social_media_id":4,"file_id":360}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:20:18',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/4/attachments',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            20 => [
                'auditable_id' => 4,
                'auditable_type' => 'App\\Models\\SocialMediaAttachment',
                'created_at' => '2022-12-20 01:20:30',
                'event' => 'created',
                'id' => 21,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"social_media_id":6,"file_id":350,"id":4}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-20 01:20:30',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/6',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            21 => [
                'auditable_id' => 5,
                'auditable_type' => 'App\\Models\\SocialMediaAttachment',
                'created_at' => '2022-12-20 01:20:48',
                'event' => 'created',
                'id' => 22,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"social_media_id":5,"file_id":351,"id":5}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-20 01:20:48',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/5',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            22 => [
                'auditable_id' => 6,
                'auditable_type' => 'App\\Models\\SocialMediaAttachment',
                'created_at' => '2022-12-20 01:21:59',
                'event' => 'created',
                'id' => 23,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"social_media_id":1,"file_id":349,"id":6}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-20 01:21:59',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            23 => [
                'auditable_id' => 4,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:23:56',
                'event' => 'updated',
                'id' => 24,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"status":"Approved"}',
                'old_values' => '{"status":"Client Created Draft"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:23:56',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/4',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            24 => [
                'auditable_id' => 7,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:33:58',
                'event' => 'updated',
                'id' => 25,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"post_date":"2022-12-21 00:45:16"}',
                'old_values' => '{"post_date":"2022-12-19 00:45:16"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:33:58',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/7',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            25 => [
                'auditable_id' => 5,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:38:53',
                'event' => 'updated',
                'id' => 26,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"post_date":"2023-01-11 13:00:26"}',
                'old_values' => '{"post_date":"2022-12-19 00:40:26"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:38:53',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/5',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            26 => [
                'auditable_id' => 4,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:39:08',
                'event' => 'updated',
                'id' => 27,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"post_date":"2023-01-25 16:38:56"}',
                'old_values' => '{"post_date":"2022-12-19 00:38:56"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:39:08',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/4',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            27 => [
                'auditable_id' => 3,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:39:25',
                'event' => 'updated',
                'id' => 28,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"post_date":"2023-02-15 07:38:00"}',
                'old_values' => '{"post_date":"2022-12-19 00:38:00"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:39:25',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/3',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            28 => [
                'auditable_id' => 2,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:39:44',
                'event' => 'updated',
                'id' => 29,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"post_date":"2023-03-11 21:36:54"}',
                'old_values' => '{"post_date":"2022-12-19 00:36:54"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:39:44',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/2',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            29 => [
                'auditable_id' => 1,
                'auditable_type' => 'App\\Models\\SocialMedia',
                'created_at' => '2022-12-20 01:39:58',
                'event' => 'updated',
                'id' => 30,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"post_date":"2022-12-29 18:35:40"}',
                'old_values' => '{"post_date":"2022-12-19 00:35:40"}',
                'tags' => null,
                'updated_at' => '2022-12-20 01:39:58',
                'url' => 'https://api-demo.indy.com.au/api/v1/social-media/1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
            30 => [
                'auditable_id' => 1,
                'auditable_type' => 'App\\Models\\PrinterJob',
                'created_at' => '2022-12-20 04:33:09',
                'event' => 'created',
                'id' => 31,
                'ip_address' => '122.150.48.224',
                'new_values' => '{"client_id":1,"printer_id":1,"status":"Awaiting Quote","customer_name":null,"product":"Postcards","option":"Two sided","kinds":null,"quantity":"1500","run_ons":null,"format":"Landscape","final_trim_size":null,"reference":null,"notes":null,"additional_options":null,"delivery":"To Venue","price":null,"blind_shipping":false,"reseller_samples":false,"created_by":7,"stocks":"Gloss","coding":"Medium gsm paper","address":"to Venue","purchase_order_number":null,"description":"Mothers Day Cards","id":1}',
                'old_values' => '[]',
                'tags' => null,
                'updated_at' => '2022-12-20 04:33:09',
                'url' => 'https://api-demo.indy.com.au/api/v1/clients/1/printer-jobs',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'user_id' => 7,
                'user_type' => 'App\\Models\\User',
            ],
        ]);
    }
}