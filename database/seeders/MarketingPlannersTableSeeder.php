<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MarketingPlannersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('marketing_planners')->delete();

        \DB::table('marketing_planners')->insert([
            0 => [
                'client_id' => 1,
                'created_at' => '2022-12-19 00:35:40',
                'created_by' => 7,
                'deleted_at' => null,
                'description' => '{"blocks": [{"key": "2o5f7", "data": {}, "text": "Free drink on arrival. ", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'end_date' => '2023-02-06 17:00:00',
                'event_name' => 'Melbourne Cup',
                'id' => 1,
                'is_recurring' => 0,
                'start_date' => '2022-12-16 17:00:00',
                'updated_at' => '2022-12-20 05:55:22',
                'updated_by' => 7,
            ],
            1 => [
                'client_id' => 1,
                'created_at' => '2022-12-19 00:36:54',
                'created_by' => 7,
                'deleted_at' => null,
                'description' => '{"blocks": [{"key": "44hdu", "data": {}, "text": "Free Egg\'s", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'end_date' => '2023-04-04 04:00:00',
                'event_name' => 'Mega Draw Eggcitment',
                'id' => 2,
                'is_recurring' => 0,
                'start_date' => '2022-12-18 02:00:00',
                'updated_at' => '2022-12-20 05:46:41',
                'updated_by' => 7,
            ],
            2 => [
                'client_id' => 1,
                'created_at' => '2022-12-19 00:38:01',
                'created_by' => 7,
                'deleted_at' => null,
                'description' => '{"blocks": [{"key": "2e86b", "data": {}, "text": "test", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'end_date' => '2023-01-25 04:00:00',
                'event_name' => 'Australia Day 2023',
                'id' => 3,
                'is_recurring' => 0,
                'start_date' => '2022-12-17 04:00:00',
                'updated_at' => '2022-12-20 05:48:48',
                'updated_by' => 7,
            ],
            3 => [
                'client_id' => 1,
                'created_at' => '2022-12-19 00:38:56',
                'created_by' => 7,
                'deleted_at' => null,
                'description' => '{"blocks": [{"key": "5f3b1", "data": {}, "text": "Free drink....", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'end_date' => '2023-05-12 14:00:00',
                'event_name' => 'Mother\'s Day',
                'id' => 4,
                'is_recurring' => 0,
                'start_date' => '2023-02-28 13:00:00',
                'updated_at' => '2022-12-19 00:38:56',
                'updated_by' => null,
            ],
            4 => [
                'client_id' => 1,
                'created_at' => '2022-12-19 00:40:26',
                'created_by' => 7,
                'deleted_at' => null,
                'description' => '{"blocks": [{"key": "34t0p", "data": {}, "text": "Test brief.....", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'end_date' => '2023-04-24 14:00:00',
                'event_name' => 'Anzac Day',
                'id' => 5,
                'is_recurring' => 0,
                'start_date' => '2023-01-31 13:00:00',
                'updated_at' => '2022-12-19 00:40:26',
                'updated_by' => null,
            ],
            5 => [
                'client_id' => 1,
                'created_at' => '2022-12-19 00:42:52',
                'created_by' => 7,
                'deleted_at' => null,
                'description' => '{"blocks": [{"key": "akqkb", "data": {}, "text": "Free Entry..... (Test)", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'end_date' => '2023-11-02 13:00:00',
                'event_name' => 'Step into Spring',
                'id' => 6,
                'is_recurring' => 0,
                'start_date' => '2023-07-31 14:00:00',
                'updated_at' => '2022-12-19 00:42:52',
                'updated_by' => null,
            ],
            6 => [
                'client_id' => 1,
                'created_at' => '2022-12-19 00:45:16',
                'created_by' => 7,
                'deleted_at' => null,
                'description' => '{"blocks": [{"key": "5p1r0", "data": {}, "text": "free entry ", "type": "unstyled", "depth": 0, "entityRanges": [], "inlineStyleRanges": []}], "entityMap": {}}',
                'end_date' => '2023-10-12 13:00:00',
                'event_name' => 'World Cup Major Promo',
                'id' => 7,
                'is_recurring' => 0,
                'start_date' => '2023-03-13 13:00:00',
                'updated_at' => '2022-12-19 00:45:16',
                'updated_by' => null,
            ],
        ]);
    }
}
