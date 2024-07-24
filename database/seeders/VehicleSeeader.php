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
        $cars = [
            ["year" => 2006, "make" => "Toyota", "model" => "Sienna", "vin" => "5TDZA23C56S566778"],
            ["year" => 2010, "make" => "Ford", "model" => "Econoline", "vin" => "1FDEE3FL1ADA68677"],
            ["year" => 2006, "make" => "Ford", "model" => "Econoline", "vin" => "1FTSS34L56HB31363"],
            ["year" => 2023, "make" => "Chevy", "model" => "Suburban", "vin" => "1GNSKEKD9PR238670"],
            ["year" => 2020, "make" => "Toyota", "model" => "Sienna", "vin" => "5TDKZ3DC2LS029988"],
            ["year" => 2020, "make" => "Toyota", "model" => "Sienna", "vin" => "5TDYZ3DC4LS053218"],
            ["year" => 2007, "make" => "Ford", "model" => "Econoline", "vin" => "1FBSS31L57DB34734"]
        ];
        
        $sum = 1;
        foreach ($cars as $vehicle) {
            Vehicle::create([
                'year' => $vehicle['year'],
                'make' => $vehicle['make'],
                'model' => $vehicle['model'],
                'vin' => $vehicle['vin'],
                'number_vehicle' => $sum,
                'user_id'  => ($sum == 1) ? 4 : null,
            ]);
            $sum++;
        }
        

    }
}
