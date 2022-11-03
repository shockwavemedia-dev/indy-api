<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LibraryCategoriesSeeder::class,
            UsersTableSeeder::class,
            DepartmentsSeeder::class,
            ServicesSeeder::class
        ]);
    }
}
