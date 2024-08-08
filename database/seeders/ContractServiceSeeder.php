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

        $array = [
            [
                "company" => "Caldwell County",
                "contact_name" => "Caldwell County",
                "wheelchair" => 120,
                "ambulatory" => 55,
                "out_of_hours" => 45,
                "saturdays" => 65,
                "sundays_holidays" => 85,
                "companion" => 35,
                "additional_waiting" => 35,
                "fast_track" => 15,
                'if_not_cancel' => 0,
                'rate_per_mile' => 4,
                'overcharge' => 0,
                'address' => 'Medicaid Transportation NEMT PO Box 200 Lenoir, NC 28645',
                'phone' => '(828) 426-8217',
                'state' => 'Active',
                'date_start' => '2023-07-28',
                'date_end' => '2023-07-28'
            ],
            [
                "company" => "Burke County",
                "contact_name" => "Burke County",
                "wheelchair" => 120,
                "ambulatory" => 55,
                "out_of_hours" => 45,
                "saturdays" => 65,
                "sundays_holidays" => 85,
                "companion" => 25,
                "additional_waiting" => 35,
                "fast_track" => 15,
                'if_not_cancel' => 0,
                'rate_per_mile' => 4,
                'overcharge' => 0,
                'address' => '700 East Parker Road Morganton, NC 28655',
                'phone' => '(828) 764-9612',
                'state' => 'Active',
                'date_start' => '2023-07-28',
                'date_end' => '2023-07-28'
            ],
            [
                "company" => "Novant Health Rowan Medical Center",
                "contact_name" => "Novant Health",
                "wheelchair" => 95,
                "ambulatory" => 55,
                "out_of_hours" => 45,
                "saturdays" => 65,
                "sundays_holidays" => 85,
                "companion" => 15,
                "additional_waiting" => 35,
                "fast_track" => 15,
                'if_not_cancel' => 0,
                'rate_per_mile' => 4,
                'overcharge' => 0,
                'address' => '123 Main St.',
                'phone' => '123456789',
                'state' => 'Active',
                'date_start' => '2023-07-28',
                'date_end' => '2023-07-28'
            ],
            [
                "company" => "Carteret County",
                "contact_name" => "Carteret County",
                "wheelchair" => 120,
                "ambulatory" => 55,
                "out_of_hours" => 45,
                "saturdays" => 65,
                "sundays_holidays" => 85,
                "companion" => 25,
                "additional_waiting" => 35,
                "fast_track" => 15,
                'if_not_cancel' => 0,
                'rate_per_mile' => 4,
                'overcharge' => 0,
                'address' => '123 Main St.',
                'phone' => '123456789',
                'state' => 'Active',
                'date_start' => '2023-07-28',
                'date_end' => '2023-07-28'
            ],
        ];

        foreach ($array as $key => $value) {
            ServiceContract::create($value);
        }
    }
}
