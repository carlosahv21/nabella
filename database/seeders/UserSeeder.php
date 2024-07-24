<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => ('secret')
        ])->assignRole('Admin');

        User::factory()->create([
            'name' => 'Laura ',
            'email' => 'laura@nabella.com',
            'password' => ('secret')
        ])->assignRole('Admin');

        User::factory()->create([
            'name' => 'Cony',
            'email' => 'cony@nabella.com',
            'password' => ('secret')
        ])->assignRole('Admin');

        User::factory()->create([
            'name' => 'Carlos Hernandez',
            'email' => 'carlos@material.com',
            'password' => ('secret')
        ])->assignRole('Driver');

        $data = [
            ["name" => "Miguel Chavez", "dob" => "1979-06-24", "dl_state" => "NC", "dl_number" => "32581474", "date_of_hire" => "Owner"],
            ["name" => "Laura Chavez", "dob" => "1987-01-23", "dl_state" => "NC", "dl_number" => "36083553", "date_of_hire" => "Owner"],
            ["name" => "Ger Yang", "dob" => "1994-05-27", "dl_state" => "NC", "dl_number" => "33975298", "date_of_hire" => "2023-07-28"],
            ["name" => "Freddy Nieto", "dob" => "1970-08-17", "dl_state" => "NC", "dl_number" => "29050340", "date_of_hire" => "2023-08-25"],
            ["name" => "Wilmar Jimenez", "dob" => "1982-07-10", "dl_state" => "NC", "dl_number" => "35825495", "date_of_hire" => "2023-11-25"],
            ["name" => "Omar Figueroa Rodriguez", "dob" => "1986-07-22", "dl_state" => "NC", "dl_number" => "42514740", "date_of_hire" => "2024-01-22"],
            ["name" => "Judy Hemric", "dob" => "1959-10-31", "dl_state" => "NC", "dl_number" => "24998006", "date_of_hire" => "2024-03-13"]
        ];
        
        foreach ($data as $user) {
            $email = strtolower(str_replace(' ', '_', $user['name'])) . '@example.com';
            User::create([
                'name' => $user['name'],
                'dob' => $user['dob'],
                'dl_state' => $user['dl_state'],
                'dl_number' => $user['dl_number'],
                'date_of_hire' => $user['date_of_hire'],
                'email' => $email,
                'password' => bcrypt('password'), // Asignar una contraseña por defecto
                'created_at' => now(),
                'updated_at' => now(),
            ])->assignRole('Driver');
        }
        
    }
}
