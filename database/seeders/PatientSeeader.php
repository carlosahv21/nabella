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
                'service_contract_id' => $faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'first_name' => $faker->name,
                'last_name' => $faker->lastName,
                'birth_date' => $faker->dateTimeBetween('-1 year', '+1 year'),
                'phone1' => $faker->phoneNumber,
                'phone2' => $faker->phoneNumber,
                'medicalid' => $faker->text(5),
                'billing_code' => $faker->randomElement(['A0130-Wheelchair', 'A0120 Ambulatory', 'Rowan A0100']),
                'emergency_contact' => $faker->phoneNumber,
                'date_start' => $faker->dateTimeBetween('-1 year', '+1 year'),
                'date_end' => $faker->dateTimeBetween('-1 year', '+1 year'),
                'observations' => $faker->text(100),
            ]);
        }
    }
}
