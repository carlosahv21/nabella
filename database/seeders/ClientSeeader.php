<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class ClientSeeader extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Client::create([
                'company' => $faker->company,
                'contact_name' => $faker->name,
                'rate_per_mile' => $faker->randomFloat(2, 0, 50),
            ]);
        }
    }
}
