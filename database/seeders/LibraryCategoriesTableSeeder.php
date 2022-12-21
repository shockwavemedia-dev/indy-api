<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LibraryCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('library_categories')->delete();
        
        \DB::table('library_categories')->insert(array (
            0 => 
            array (
                'created_at' => '2022-11-28 02:48:45',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 1,
                'name' => 'AFL',
                'slug' => 'afl',
                'updated_at' => '2022-11-28 02:48:45',
                'updated_by' => NULL,
            ),
            1 => 
            array (
                'created_at' => '2022-11-28 02:54:44',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 2,
                'name' => 'Anzac Day',
                'slug' => 'anzac-day',
                'updated_at' => '2022-11-28 02:54:44',
                'updated_by' => NULL,
            ),
            2 => 
            array (
                'created_at' => '2022-11-28 03:11:11',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 3,
                'name' => 'App',
                'slug' => 'app',
                'updated_at' => '2022-11-28 03:11:11',
                'updated_by' => NULL,
            ),
            3 => 
            array (
                'created_at' => '2022-11-28 03:14:50',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 4,
                'name' => 'Happy Hour',
                'slug' => 'happy-hour',
                'updated_at' => '2022-11-28 03:14:50',
                'updated_by' => NULL,
            ),
            4 => 
            array (
                'created_at' => '2022-11-28 03:20:08',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 5,
                'name' => 'Birthday',
                'slug' => 'birthday',
                'updated_at' => '2022-11-28 03:20:08',
                'updated_by' => NULL,
            ),
            5 => 
            array (
                'created_at' => '2022-11-28 03:24:23',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 6,
                'name' => 'Body Heat',
                'slug' => 'body-heat',
                'updated_at' => '2022-11-28 03:24:23',
                'updated_by' => NULL,
            ),
            6 => 
            array (
                'created_at' => '2022-11-28 03:24:56',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 7,
                'name' => 'Club Safe',
                'slug' => 'club-safe',
                'updated_at' => '2022-11-28 03:24:56',
                'updated_by' => NULL,
            ),
            7 => 
            array (
                'created_at' => '2022-11-28 03:26:53',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 8,
                'name' => 'Electrical Promotions',
                'slug' => 'electrical-promotions',
                'updated_at' => '2022-11-28 03:26:53',
                'updated_by' => NULL,
            ),
            8 => 
            array (
                'created_at' => '2022-11-28 03:31:28',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 9,
                'name' => 'Beer Promos',
                'slug' => 'beer-promos',
                'updated_at' => '2022-11-28 03:31:28',
                'updated_by' => NULL,
            ),
            9 => 
            array (
                'created_at' => '2022-11-28 03:32:57',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 10,
                'name' => 'Christmas in July',
                'slug' => 'christmas-in-july',
                'updated_at' => '2022-11-28 03:32:57',
                'updated_by' => NULL,
            ),
            10 => 
            array (
                'created_at' => '2022-11-28 03:35:50',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 11,
                'name' => 'Car Promotions',
                'slug' => 'car-promotions',
                'updated_at' => '2022-11-28 03:35:50',
                'updated_by' => NULL,
            ),
            11 => 
            array (
                'created_at' => '2022-11-28 03:38:33',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 12,
                'name' => 'Bingo',
                'slug' => 'bingo',
                'updated_at' => '2022-11-28 03:38:33',
                'updated_by' => NULL,
            ),
            12 => 
            array (
                'created_at' => '2022-11-28 03:48:40',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 13,
                'name' => 'Courtesy Bus',
                'slug' => 'courtesy-bus',
                'updated_at' => '2022-11-28 03:48:40',
                'updated_by' => NULL,
            ),
            13 => 
            array (
                'created_at' => '2022-11-28 03:53:39',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 14,
                'name' => 'Cruise Promotions',
                'slug' => 'cruise-promotions',
                'updated_at' => '2022-11-28 03:53:39',
                'updated_by' => NULL,
            ),
            14 => 
            array (
                'created_at' => '2022-11-28 03:59:21',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 15,
                'name' => 'Facebook',
                'slug' => 'facebook',
                'updated_at' => '2022-11-28 03:59:21',
                'updated_by' => NULL,
            ),
            15 => 
            array (
                'created_at' => '2022-11-28 04:02:15',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 16,
                'name' => 'Fathers Day',
                'slug' => 'fathers-day',
                'updated_at' => '2022-11-28 04:02:15',
                'updated_by' => NULL,
            ),
            16 => 
            array (
                'created_at' => '2022-11-28 04:05:22',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 17,
                'name' => 'Food Specials',
                'slug' => 'food-specials',
                'updated_at' => '2022-11-28 04:05:22',
                'updated_by' => NULL,
            ),
            17 => 
            array (
                'created_at' => '2022-11-28 04:09:15',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 18,
                'name' => 'Wifi',
                'slug' => 'wifi',
                'updated_at' => '2022-11-28 04:09:15',
                'updated_by' => NULL,
            ),
            18 => 
            array (
                'created_at' => '2022-11-28 04:11:53',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 19,
                'name' => 'Functions',
                'slug' => 'functions',
                'updated_at' => '2022-11-28 04:11:53',
                'updated_by' => NULL,
            ),
            19 => 
            array (
                'created_at' => '2022-11-28 04:45:13',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 20,
                'name' => 'Gambling',
                'slug' => 'gambling',
                'updated_at' => '2022-11-28 04:45:13',
                'updated_by' => NULL,
            ),
            20 => 
            array (
                'created_at' => '2022-12-07 00:14:28',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 21,
                'name' => 'Instagram',
                'slug' => 'instagram',
                'updated_at' => '2022-12-07 00:14:28',
                'updated_by' => NULL,
            ),
            21 => 
            array (
                'created_at' => '2022-12-07 00:20:04',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 22,
                'name' => 'Karaoke',
                'slug' => 'karaoke',
                'updated_at' => '2022-12-07 00:20:04',
                'updated_by' => NULL,
            ),
            22 => 
            array (
                'created_at' => '2022-12-07 00:25:37',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 23,
                'name' => 'Kids eat free',
                'slug' => 'kids-eat-free',
                'updated_at' => '2022-12-07 00:25:37',
                'updated_by' => NULL,
            ),
            23 => 
            array (
                'created_at' => '2022-12-07 00:34:38',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 24,
                'name' => 'Live Music',
                'slug' => 'live-music',
                'updated_at' => '2022-12-07 00:34:38',
                'updated_by' => NULL,
            ),
            24 => 
            array (
                'created_at' => '2022-12-07 00:41:43',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 25,
                'name' => 'Meat Raffle',
                'slug' => 'meat-raffle',
                'updated_at' => '2022-12-07 00:41:43',
                'updated_by' => NULL,
            ),
            25 => 
            array (
                'created_at' => '2022-12-07 00:49:52',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 26,
                'name' => 'Membership',
                'slug' => 'membership',
                'updated_at' => '2022-12-07 00:49:52',
                'updated_by' => NULL,
            ),
            26 => 
            array (
                'created_at' => '2022-12-07 01:10:46',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 27,
                'name' => 'Mothers Day',
                'slug' => 'mothers-day',
                'updated_at' => '2022-12-07 01:10:46',
                'updated_by' => NULL,
            ),
            27 => 
            array (
                'created_at' => '2022-12-07 01:16:26',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 28,
                'name' => 'NRL',
                'slug' => 'nrl',
                'updated_at' => '2022-12-07 01:16:26',
                'updated_by' => NULL,
            ),
            28 => 
            array (
                'created_at' => '2022-12-07 01:21:13',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 29,
                'name' => 'Poker',
                'slug' => 'poker',
                'updated_at' => '2022-12-07 01:21:13',
                'updated_by' => NULL,
            ),
            29 => 
            array (
                'created_at' => '2022-12-07 01:25:42',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 30,
                'name' => 'Seafood Raffle',
                'slug' => 'seafood-raffle',
                'updated_at' => '2022-12-07 01:25:42',
                'updated_by' => NULL,
            ),
            30 => 
            array (
                'created_at' => '2022-12-07 01:31:37',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 31,
                'name' => 'Seniors Day Out',
                'slug' => 'seniors-day-out',
                'updated_at' => '2022-12-07 01:31:37',
                'updated_by' => NULL,
            ),
            31 => 
            array (
                'created_at' => '2022-12-07 01:33:45',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 32,
                'name' => 'St Patricks Day',
                'slug' => 'st-patricks-day',
                'updated_at' => '2022-12-07 01:33:45',
                'updated_by' => NULL,
            ),
            32 => 
            array (
                'created_at' => '2022-12-07 01:37:39',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 33,
                'name' => 'State of Origin',
                'slug' => 'state-of-origin',
                'updated_at' => '2022-12-07 01:37:39',
                'updated_by' => NULL,
            ),
            33 => 
            array (
                'created_at' => '2022-12-07 01:43:44',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 34,
                'name' => 'Trivia',
                'slug' => 'trivia',
                'updated_at' => '2022-12-07 01:43:44',
                'updated_by' => NULL,
            ),
            34 => 
            array (
                'created_at' => '2022-12-07 01:56:10',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 35,
                'name' => 'Christmas Raffle',
                'slug' => 'christmas-raffle',
                'updated_at' => '2022-12-07 01:56:10',
                'updated_by' => NULL,
            ),
            35 => 
            array (
                'created_at' => '2022-12-07 02:04:48',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 36,
                'name' => 'Members Raffle',
                'slug' => 'members-raffle',
                'updated_at' => '2022-12-07 02:04:48',
                'updated_by' => NULL,
            ),
            36 => 
            array (
                'created_at' => '2022-12-07 02:25:41',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 37,
                'name' => 'New Years Eve',
                'slug' => 'new-years-eve',
                'updated_at' => '2022-12-07 02:25:41',
                'updated_by' => NULL,
            ),
            37 => 
            array (
                'created_at' => '2022-12-07 03:24:30',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 38,
                'name' => 'Australia Day',
                'slug' => 'australia-day',
                'updated_at' => '2022-12-07 03:24:30',
                'updated_by' => NULL,
            ),
            38 => 
            array (
                'created_at' => '2022-12-07 03:43:13',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 39,
                'name' => 'Valentine\'s Day',
                'slug' => 'valentines-day',
                'updated_at' => '2022-12-07 03:43:13',
                'updated_by' => NULL,
            ),
            39 => 
            array (
                'created_at' => '2022-12-07 03:58:56',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 40,
                'name' => 'Melbourne Cup',
                'slug' => 'melbourne-cup',
                'updated_at' => '2022-12-07 03:58:56',
                'updated_by' => NULL,
            ),
            40 => 
            array (
                'created_at' => '2022-12-07 04:40:30',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 41,
                'name' => 'Easter',
                'slug' => 'easter',
                'updated_at' => '2022-12-07 04:40:30',
                'updated_by' => NULL,
            ),
            41 => 
            array (
                'created_at' => '2022-12-07 05:15:51',
                'created_by' => 1,
                'deleted_at' => NULL,
                'id' => 42,
                'name' => 'Christmas Promo',
                'slug' => 'christmas-promo',
                'updated_at' => '2022-12-07 05:15:51',
                'updated_by' => NULL,
            ),
        ));
        
        
    }
}