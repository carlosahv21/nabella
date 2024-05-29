<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\Vehicle;

class VehicleSeeader extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $cars = [];

        for ($i = 0; $i < 10; $i++) {
            Vehicle::create([
                'year' => $faker->year,
                'make' => $faker->company,
                'model' => $faker->word,
                'type' => $faker->randomElement(['Sedan', 'SUV', 'Coupe', 'Hatchback', 'Crossover']),
                'vin' => $faker->text(5),
                'user_id'  => 2,
                'value' => $faker->randomFloat(2, 1000, 50000)
            ]);
        }
    }
}
