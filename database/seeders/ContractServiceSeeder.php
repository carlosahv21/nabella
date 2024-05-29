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
                'rate_per_mile' => $faker->randomFloat(2, 0, 50),
                'overcharge' => $faker->randomFloat(2, 0, 50),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'subject' => $faker->word(10),
                'state' => 'Active',
                'date_start' => $faker->dateTimeBetween('-1 year', '+1 year'),
                'date_end' => $faker->dateTimeBetween('-1 year', '+1 year'),
            ]);
        }
    }
}
