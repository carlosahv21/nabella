<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Patient;
use Faker\Factory as Faker;

class PatientSeeader extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Patient::create([
                'county' => $faker->city,
                'name' => $faker->name,
                'home_address' => $faker->streetAddress,
                'destination_address' => $faker->streetAddress,
                'phone' => $faker->phoneNumber,
                'medicaid' => $faker->numberBetween(1000, 5000),
                'billing_code' => $faker->randomElement(['A0130-Wheelchair', 'A0120 Ambulatory', 'Rowan A0100']),
                'ambulatory' => $faker->text(100),
                'observations' => $faker->text(100),
            ]);
        }
    }
}
