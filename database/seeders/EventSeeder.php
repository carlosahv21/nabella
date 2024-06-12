<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
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

            // Generar una cantidad aleatoria de minutos (15, 30, 45, 60)
            $randomMinutesArray = [15, 30, 45, 60];
            $randomMinutes = $randomMinutesArray[array_rand($randomMinutesArray)];

            // Calcular el timestamp del end sumando los minutos aleatorios al start
            $endTimestamp = strtotime("+$randomMinutes minutes", $randomDayWithTimeTimestamp);

            // Formatear la fecha de end
            $end = date('Y-m-d H:i:s', $endTimestamp);

            Event::create([
                'name' => $faker->text(8),
                'start_time' => $start,
                'end_time' => $end
            ]);
        }
    }
}
