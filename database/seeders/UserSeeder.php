<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => ('secret')
        ])->assignRole('Admin');

        User::factory()->create([
            'name' => 'Laura ',
            'email' => 'laura@nabella.com',
            'password' => ('nabella')
        ])->assignRole('Admin');

        User::factory()->create([
            'name' => 'Cony',
            'email' => 'cony@nabella.com',
            'password' => ('nabella')
        ])->assignRole('Admin');

        User::factory()->create([
            'name' => 'Carlos Hernandez',
            'email' => 'carlos@material.com',
            'password' => ('secret')
        ])->assignRole('Driver');

        User::factory(30)->create(['password' => ('secret')]);
    }
}
