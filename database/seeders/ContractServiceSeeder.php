<?php

namespace Database\Seeders;

use App\Models\ServiceContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class ContractServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            ServiceContract::create([
                'company' => $faker->company,
                'contact_name' => $faker->name,
                'wheelchair' => $faker->randomFloat(2, 0, 50),
                'ambulatory' => $faker->randomFloat(2, 0, 50),
                'out_of_hours' => $faker->randomFloat(2, 0, 50),
                'saturdays' => $faker->randomFloat(2, 0, 50),
                'sundays_holidays' => $faker->randomFloat(2, 0, 50),
                'companion' => $faker->randomFloat(2, 0, 50),
                'additional_waiting' => $faker->randomFloat(2, 0, 50),
                'after' => $faker->randomFloat(2, 0, 50),
                'fast_track' => $faker->randomFloat(2, 0, 50),
                'if_not_cancel' => $faker->randomFloat(2, 0, 50),
                'rate_per_mile' => $faker->randomFloat(2, 0, 50),
                'overcharge' => $faker->randomFloat(2, 0, 50),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'state' => 'Active',
                'date_start' => $faker->dateTimeBetween('-1 year', '+1 year'),
                'date_end' => $faker->dateTimeBetween('-1 year', '+1 year'),
            ]);
        }
    }
}
