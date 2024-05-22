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
        Seeder::call(RoleSeeder::class);
        Seeder::call(UserSeeder::class);
    }
}
