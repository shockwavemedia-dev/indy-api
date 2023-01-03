<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OauthPersonalAccessClientsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('oauth_personal_access_clients')->delete();

        \DB::table('oauth_personal_access_clients')->insert([
            0 => [
                'client_id' => 1,
                'created_at' => '2022-12-16 06:17:44',
                'id' => 1,
                'updated_at' => '2022-12-16 06:17:44',
            ],
        ]);
    }
}
