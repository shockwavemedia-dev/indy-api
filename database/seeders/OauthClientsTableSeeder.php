<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('oauth_clients')->delete();

        \DB::table('oauth_clients')->insert([
            0 => [
                'created_at' => '2022-12-16 06:17:44',
                'id' => 1,
                'name' => 'Indy Personal Access Client',
                'password_client' => 0,
                'personal_access_client' => 1,
                'provider' => null,
                'redirect' => 'http://localhost',
                'revoked' => 0,
                'secret' => 'JdZyvftbPNg5XTJiQbFNPL9jquKOjvW2RPCNgNdh',
                'updated_at' => '2022-12-16 06:17:44',
                'user_id' => null,
            ],
            1 => [
                'created_at' => '2022-12-16 06:17:44',
                'id' => 2,
                'name' => 'Indy Password Grant Client',
                'password_client' => 1,
                'personal_access_client' => 0,
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'revoked' => 0,
                'secret' => '2us44aHiKwvn5TsmP9PEwV1sBItSDzZHJfzrtVS5',
                'updated_at' => '2022-12-16 06:17:44',
                'user_id' => null,
            ],
        ]);
    }
}
