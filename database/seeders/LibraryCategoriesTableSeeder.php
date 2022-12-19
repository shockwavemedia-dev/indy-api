<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibraryCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('library_categories')->delete();

        DB::table('library_categories')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'AFL',
                'slug' => 'afl',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 02:48:45',
                'updated_at' => '2022-11-28 02:48:45',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Anzac Day',
                'slug' => 'anzac-day',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 02:54:44',
                'updated_at' => '2022-11-28 02:54:44',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'App',
                'slug' => 'app',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:11:11',
                'updated_at' => '2022-11-28 03:11:11',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Happy Hour',
                'slug' => 'happy-hour',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:14:50',
                'updated_at' => '2022-11-28 03:14:50',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Birthday',
                'slug' => 'birthday',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:20:08',
                'updated_at' => '2022-11-28 03:20:08',
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Body Heat',
                'slug' => 'body-heat',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:24:23',
                'updated_at' => '2022-11-28 03:24:23',
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Club Safe',
                'slug' => 'club-safe',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:24:56',
                'updated_at' => '2022-11-28 03:24:56',
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Electrical Promotions',
                'slug' => 'electrical-promotions',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:26:53',
                'updated_at' => '2022-11-28 03:26:53',
                'deleted_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Beer Promos',
                'slug' => 'beer-promos',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:31:28',
                'updated_at' => '2022-11-28 03:31:28',
                'deleted_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'Christmas in July',
                'slug' => 'christmas-in-july',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:32:57',
                'updated_at' => '2022-11-28 03:32:57',
                'deleted_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'Car Promotions',
                'slug' => 'car-promotions',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:35:50',
                'updated_at' => '2022-11-28 03:35:50',
                'deleted_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'Bingo',
                'slug' => 'bingo',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:38:33',
                'updated_at' => '2022-11-28 03:38:33',
                'deleted_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'Courtesy Bus',
                'slug' => 'courtesy-bus',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:48:40',
                'updated_at' => '2022-11-28 03:48:40',
                'deleted_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'Cruise Promotions',
                'slug' => 'cruise-promotions',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:53:39',
                'updated_at' => '2022-11-28 03:53:39',
                'deleted_at' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'name' => 'Facebook',
                'slug' => 'facebook',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 03:59:21',
                'updated_at' => '2022-11-28 03:59:21',
                'deleted_at' => NULL,
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'Fathers Day',
                'slug' => 'fathers-day',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 04:02:15',
                'updated_at' => '2022-11-28 04:02:15',
                'deleted_at' => NULL,
            ),
            16 =>
            array (
                'id' => 17,
                'name' => 'Food Specials',
                'slug' => 'food-specials',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 04:05:22',
                'updated_at' => '2022-11-28 04:05:22',
                'deleted_at' => NULL,
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'Wifi',
                'slug' => 'wifi',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 04:09:15',
                'updated_at' => '2022-11-28 04:09:15',
                'deleted_at' => NULL,
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'Functions',
                'slug' => 'functions',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 04:11:53',
                'updated_at' => '2022-11-28 04:11:53',
                'deleted_at' => NULL,
            ),
            19 =>
            array (
                'id' => 20,
                'name' => 'Gambling',
                'slug' => 'gambling',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-11-28 04:45:13',
                'updated_at' => '2022-11-28 04:45:13',
                'deleted_at' => NULL,
            ),
            20 =>
            array (
                'id' => 21,
                'name' => 'Instagram',
                'slug' => 'instagram',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 00:14:28',
                'updated_at' => '2022-12-07 00:14:28',
                'deleted_at' => NULL,
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'Karaoke',
                'slug' => 'karaoke',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 00:20:04',
                'updated_at' => '2022-12-07 00:20:04',
                'deleted_at' => NULL,
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'Kids eat free',
                'slug' => 'kids-eat-free',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 00:25:37',
                'updated_at' => '2022-12-07 00:25:37',
                'deleted_at' => NULL,
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'Live Music',
                'slug' => 'live-music',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 00:34:38',
                'updated_at' => '2022-12-07 00:34:38',
                'deleted_at' => NULL,
            ),
            24 =>
            array (
                'id' => 25,
                'name' => 'Meat Raffle',
                'slug' => 'meat-raffle',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 00:41:43',
                'updated_at' => '2022-12-07 00:41:43',
                'deleted_at' => NULL,
            ),
            25 =>
            array (
                'id' => 26,
                'name' => 'Membership',
                'slug' => 'membership',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 00:49:52',
                'updated_at' => '2022-12-07 00:49:52',
                'deleted_at' => NULL,
            ),
            26 =>
            array (
                'id' => 27,
                'name' => 'Mothers Day',
                'slug' => 'mothers-day',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:10:46',
                'updated_at' => '2022-12-07 01:10:46',
                'deleted_at' => NULL,
            ),
            27 =>
            array (
                'id' => 28,
                'name' => 'NRL',
                'slug' => 'nrl',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:16:26',
                'updated_at' => '2022-12-07 01:16:26',
                'deleted_at' => NULL,
            ),
            28 =>
            array (
                'id' => 29,
                'name' => 'Poker',
                'slug' => 'poker',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:21:13',
                'updated_at' => '2022-12-07 01:21:13',
                'deleted_at' => NULL,
            ),
            29 =>
            array (
                'id' => 30,
                'name' => 'Seafood Raffle',
                'slug' => 'seafood-raffle',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:25:42',
                'updated_at' => '2022-12-07 01:25:42',
                'deleted_at' => NULL,
            ),
            30 =>
            array (
                'id' => 31,
                'name' => 'Seniors Day Out',
                'slug' => 'seniors-day-out',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:31:37',
                'updated_at' => '2022-12-07 01:31:37',
                'deleted_at' => NULL,
            ),
            31 =>
            array (
                'id' => 32,
                'name' => 'St Patricks Day',
                'slug' => 'st-patricks-day',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:33:45',
                'updated_at' => '2022-12-07 01:33:45',
                'deleted_at' => NULL,
            ),
            32 =>
            array (
                'id' => 33,
                'name' => 'State of Origin',
                'slug' => 'state-of-origin',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:37:39',
                'updated_at' => '2022-12-07 01:37:39',
                'deleted_at' => NULL,
            ),
            33 =>
            array (
                'id' => 34,
                'name' => 'Trivia',
                'slug' => 'trivia',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:43:44',
                'updated_at' => '2022-12-07 01:43:44',
                'deleted_at' => NULL,
            ),
            34 =>
            array (
                'id' => 35,
                'name' => 'Christmas Raffle',
                'slug' => 'christmas-raffle',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 01:56:10',
                'updated_at' => '2022-12-07 01:56:10',
                'deleted_at' => NULL,
            ),
            35 =>
            array (
                'id' => 36,
                'name' => 'Members Raffle',
                'slug' => 'members-raffle',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 02:04:48',
                'updated_at' => '2022-12-07 02:04:48',
                'deleted_at' => NULL,
            ),
            36 =>
            array (
                'id' => 37,
                'name' => 'New Years Eve',
                'slug' => 'new-years-eve',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 02:25:41',
                'updated_at' => '2022-12-07 02:25:41',
                'deleted_at' => NULL,
            ),
            37 =>
            array (
                'id' => 38,
                'name' => 'Australia Day',
                'slug' => 'australia-day',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 03:24:30',
                'updated_at' => '2022-12-07 03:24:30',
                'deleted_at' => NULL,
            ),
            38 =>
            array (
                'id' => 39,
                'name' => 'Valentine\'s Day',
                'slug' => 'valentines-day',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 03:43:13',
                'updated_at' => '2022-12-07 03:43:13',
                'deleted_at' => NULL,
            ),
            39 =>
            array (
                'id' => 40,
                'name' => 'Melbourne Cup',
                'slug' => 'melbourne-cup',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 03:58:56',
                'updated_at' => '2022-12-07 03:58:56',
                'deleted_at' => NULL,
            ),
            40 =>
            array (
                'id' => 41,
                'name' => 'Easter',
                'slug' => 'easter',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 04:40:30',
                'updated_at' => '2022-12-07 04:40:30',
                'deleted_at' => NULL,
            ),
            41 =>
            array (
                'id' => 42,
                'name' => 'Christmas Promo',
                'slug' => 'christmas-promo',
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2022-12-07 05:15:51',
                'updated_at' => '2022-12-07 05:15:51',
                'deleted_at' => NULL,
            ),
        ));


    }
}
