<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Scheduling;

use Faker\Factory as Faker;

class SchedulingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Obtener el timestamp de "last monday"
        $startOfWeek = strtotime('last monday');


        for ($i = 0; $i < 10; $i++) {
            // Generar un número aleatorio de días (0-6) para obtener un día aleatorio de la semana actual
            $randomDays = rand(0, 6);

            // Calcular el timestamp del día aleatorio de la semana actual
            $randomDayTimestamp = strtotime("+$randomDays days", $startOfWeek);

            // Generar una hora aleatoria entre las 10:00 AM y las 6:00 PM
            $randomHour = rand(10, 18); // Horas entre 10 AM (10) y 6 PM (18)
            $randomMinute = rand(0, 59); // Minutos entre 0 y 59

            // Crear el timestamp de la hora aleatoria en el día aleatorio
            $randomDayWithTimeTimestamp = strtotime("+$randomHour hours +$randomMinute minutes", strtotime(date('Y-m-d', $randomDayTimestamp)));

            // Formatear la fecha de inicio aleatoria
            $start = date('Y-m-d H:i:s', $randomDayWithTimeTimestamp);

            $randomMinutes = $faker->randomFloat(0, 0, 60);

            // Calcular el timestamp del end sumando los minutos aleatorios al start
            $endTimestamp = strtotime("+$randomMinutes minutes", $randomDayWithTimeTimestamp);

            // Formatear la fecha de end
            $end = date('H:i', $endTimestamp);

            Scheduling::create([
                'patient_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                'hospital_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                'driver_id' => 4,
                'distance' => $faker->randomFloat(2, 10, 500).' mi',
                'duration' => $randomMinutes.' mins',
                'date' => $start,
                'check_in' => $randomHour.":".$randomMinute,
                'pick_up' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                'pick_up_time' => $end,
                'wheelchair' => $faker->randomElement([true, false]),
                'ambulatory' => $faker->randomElement([true, false]),
                'out_of_hours' => $faker->randomElement([true, false]),
                'saturdays' => $faker->randomElement([true, false]),
                'sundays_holidays' => $faker->randomElement([true, false]),
                'companion' => $faker->randomElement([true, false]),
                'aditional_waiting' => $faker->randomElement([true, false]),
                'fast_track' => $faker->randomElement([true, false]),
                'overcharge' => $faker->randomElement([true, false]),
                'auto_agend' => $faker->randomElement([true, false]),
            ]);
        }
    }
}
