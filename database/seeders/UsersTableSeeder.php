<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->where('email', '=', 'superadmin@indy.com.au')->get();

        if ($user->isEmpty() === false) {
            return;
        }

        $admin = DB::table('admin_users')->insert([
            'admin_role' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        DB::table('users')->insert([
            'morphable_id'=> 1,
            'morphable_type' => 'App\Models\Users\AdminUser',
            'email' => 'superadmin@indy.com.au',
            'password' => Hash::make('iNdYau013991'),
            'status' => 'active',
            'first_name' => 'Super Admin',
            'middle_name' => '',
            'last_name' => '',
            'contact_number' => '0',
            'gender' => 'Male',
            'birth_date' => '1990/12/12',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }
}
