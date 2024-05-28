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
                'name' => $faker->name,
                'birthdate' => $faker->date,
                'description' => $faker->text(100),
            ]);
        }
    }
}
